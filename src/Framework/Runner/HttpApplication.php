<?php

declare(strict_types=1);

namespace Yii\Framework\Runner;

use ErrorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yii\Framework\Runner\Exception\HeadersHaveBeenSentException;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\ErrorHandler\ErrorHandler;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\ErrorHandler\Renderer\HtmlRenderer;
use Yiisoft\Http\Method;
use Yiisoft\Log\Logger;
use Yiisoft\Log\Target\File\FileTarget;
use Yiisoft\Yii\Http\Application;
use Yiisoft\Yii\Http\Handler\ThrowableHandler;

use function microtime;

/**
 * Runs the Yii HTTP application.
 */
final class HttpApplication extends AbstractApplication
{
    private ErrorHandler|null $temporaryErrorHandler = null;
    protected string $bootstrapGroup = 'bootstrap-web';
    protected string $eventsGroup = 'events-web';
    protected string $diGroup = 'di-web';
    protected string $diProvidersGroup = 'di-providers-web';
    protected string $diDelegatesGroup = 'di-delegates-web';
    protected string $diTagsGroup = 'di-tags-web';
    protected string $paramsGroup = 'params-web';
    protected string $publicPath = '';
    protected string $runtimePath = '';

    /**
     * @psalm-var string[]
     */
    protected array $nestedParamsGroups = ['params', 'application-params'];
    /**
     * @psalm-var string[]
     */
    protected array $nestedEventsGroups = ['events'];

    public function withPublicPath(string $publicPath): self
    {
        $new = clone $this;
        $new->publicPath = $publicPath;

        return $new;
    }

    public function withRuntimePath(string $runtimePath): self
    {
        $new = clone $this;
        $new->runtimePath = $runtimePath;

        return $new;
    }

    public function withTemporaryErrorHandler(ErrorHandler $temporaryErrorHandler): self
    {
        $new = clone $this;
        $new->temporaryErrorHandler = $temporaryErrorHandler;

        return $new;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ErrorException
     * @throws HeadersHaveBeenSentException
     * @throws NotFoundExceptionInterface
     * @throws InvalidConfigException
     */
    public function run(): void
    {
        $startTime = microtime(true);

        // Register temporary error handler to catch error while container is building.
        $temporaryErrorHandler = $this->createTemporaryErrorHandler();
        $this->registerErrorHandler($temporaryErrorHandler);

        $container = $this->getContainer();

        /** @var Aliases $aliases */
        $aliases = $container->get(Aliases::class);

        // Set aliases for paths.
        $this->setAliases($aliases);

        // Register error handler with real container-configured dependencies.
        /** @var ErrorHandler $actualErrorHandler */
        $actualErrorHandler = $container->get(ErrorHandler::class);
        $this->registerErrorHandler($actualErrorHandler, $temporaryErrorHandler);

        $this->bootstrap();
        $this->validateEvents();

        /** @var Application $application */
        $application = $container->get(Application::class);

        /**
         * @var ServerRequestFactory $serverRequestFactory
         */
        $serverRequestFactory = $this->get(ServerRequestFactory::class);
        $serverRequestFactory = $serverRequestFactory->createFromGlobals();
        $serverRequest = $serverRequestFactory->withAttribute('applicationStartTime', $startTime);

        try {
            $application->start();
            $response = $application->handle($serverRequest);
            $this->emit($serverRequest, $response);
        } catch (Throwable $throwable) {
            $handler = new ThrowableHandler($throwable);
            /** @var ErrorCatcher $errorCatcher */
            $errorCatcher = $this->get(ErrorCatcher::class);
            $response = $errorCatcher->process($serverRequest, $handler);
            $this->emit($serverRequest, $response);
        } finally {
            $application->afterEmit($response ?? null);
            $application->shutdown();
        }
    }

    private function createTemporaryErrorHandler(): ErrorHandler
    {
        if ($this->temporaryErrorHandler !== null) {
            return $this->temporaryErrorHandler;
        }

        $logger = new Logger([new FileTarget("$this->rootPath/runtime/logs/app.log")]);

        return new ErrorHandler($logger, new HtmlRenderer());
    }

    /**
     * @throws HeadersHaveBeenSentException
     */
    private function emit(ServerRequestInterface $request, ResponseInterface $response): void
    {
        (new SapiEmitter())->emit($response, $request->getMethod() === Method::HEAD);
    }

    /**
     * @throws \Yiisoft\ErrorHandler\Exception\ErrorException
     */
    private function registerErrorHandler(ErrorHandler $registered, ErrorHandler $unregistered = null): void
    {
        $unregistered?->unregister();

        if ($this->debug) {
            $registered->debug();
        }

        $registered->register();
    }

    private function setAliases(Aliases $aliases): void
    {
        if ($this->rootPath !== '') {
            $aliases->set('@root', $this->rootPath);
        }

        if ($this->publicPath !== '') {
            $aliases->set('@public', $this->publicPath);
        }

        if ($this->runtimePath !== '') {
            $aliases->set('@runtime', $this->runtimePath);
        }
    }
}
