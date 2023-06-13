<?php

declare(strict_types=1);

namespace Yii\Framework\Runner;

use ErrorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Throwable;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Yii\Console\Application;
use Yiisoft\Yii\Console\ExitCode;
use Yiisoft\Yii\Console\Output\ConsoleBufferedOutput;

final class ConsoleApplication extends AbstractApplication
{
    protected string $bootstrapGroup = 'bootstrap-console';
    protected string $eventsGroup = 'events-console';
    protected string $diGroup = 'di-console';
    protected string $diProvidersGroup = 'di-providers-console';
    protected string $diDelegatesGroup = 'di-delegates-console';
    protected string $diTagsGroup = 'di-tags-console';
    protected string $paramsGroup = 'params-console';
    /**
     * @psalm-var string[]
     */
    protected array $nestedParamsGroups = ['params'];
    /**
     * @psalm-var string[]
     */
    protected array $nestedEventsGroups = ['events'];

    /**
     * @throws ContainerExceptionInterface
     * @throws ErrorException
     * @throws InvalidConfigException
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        $this->bootstrap();
        $this->validateEvents();

        /** @var Application $application */
        $application = $this->getContainer()->get(Application::class);
        $exitCode = ExitCode::UNSPECIFIED_ERROR;

        $input = new ArgvInput();
        $output = new ConsoleBufferedOutput();

        try {
            $application->start($input);
            $exitCode = $application->run($input, $output);
        } catch (Throwable $throwable) {
            $application->renderThrowable($throwable, $output);
        } finally {
            $application->shutdown($exitCode);
            exit($exitCode);
        }
    }
}
