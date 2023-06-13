<?php

declare(strict_types=1);

namespace Yii\Framework\Runner;

use ErrorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigInterface;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;
use Yiisoft\Config\Modifier\ReverseMerge;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Yii\Event\ListenerConfigurationChecker;

abstract class AbstractApplication implements Runner
{
    protected string $bootstrapGroup = '';
    protected string $configPath = 'config';
    protected bool $debug = true;
    protected string $eventsGroup = '';
    protected string|null $environment = null;
    protected string $diGroup = '';
    protected string $diDelegatesGroup = '';
    protected string $diProvidersGroup = '';
    protected string $diTagsGroup = '';
    /**
     * @psalm-var string[]
     */
    protected array $nestedEventsGroups = [];
    /**
     * @psalm-var string[]
     */
    protected array $nestedParamsGroups = [];
    protected string $paramsGroup = '';
    protected string $rootPath = '';
    protected bool $validateEvents = true;
    protected string $vendorPath = 'vendor';

    /**
     * @throws ContainerExceptionInterface
     * @throws ErrorException
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): mixed
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @throws ErrorException
     */
    public function getConfig(): ConfigInterface
    {
        return $this->createDefaultConfig();
    }

    /**
     * @throws ErrorException
     * @throws InvalidConfigException
     */
    public function getContainer(): ContainerInterface
    {
        return $this->createDefaultContainer();
    }

    public function withBootstrapGroup(string $bootstrapGroup): static
    {
        $new = clone $this;
        $new->bootstrapGroup = $bootstrapGroup;

        return $new;
    }

    public function withConfigPath(string $configPath): static
    {
        $new = clone $this;
        $new->configPath = $configPath;

        return $new;
    }

    public function withDebug(bool $debug): static
    {
        $new = clone $this;
        $new->debug = $debug;

        return $new;
    }

    public function withDiGroup(string $diGroup): static
    {
        $new = clone $this;
        $new->diGroup = $diGroup;

        return $new;
    }

    public function withDiDelegatesGroup(string $diDelegatesGroup): static
    {
        $new = clone $this;
        $new->diDelegatesGroup = $diDelegatesGroup;

        return $new;
    }

    public function withDiProvidersGroup(string $diProvidersGroup): static
    {
        $new = clone $this;
        $new->diProvidersGroup = $diProvidersGroup;

        return $new;
    }

    public function withDiTagsGroup(string $diTagsGroup): static
    {
        $new = clone $this;
        $new->diTagsGroup = $diTagsGroup;

        return $new;
    }

    public function withEnvironment(string $environment): static
    {
        $new = clone $this;
        $new->environment = $environment;

        return $new;
    }

    public function withEventsGroup(string $eventsGroup): static
    {
        $new = clone $this;
        $new->eventsGroup = $eventsGroup;

        return $new;
    }

    public function withNestedEventsGroups(string ...$nestedEventsGroups): static
    {
        $new = clone $this;
        $new->nestedEventsGroups = $nestedEventsGroups;

        return $new;
    }

    public function withNestedParamsGroups(string ...$nestedParamsGroups): static
    {
        $new = clone $this;
        $new->nestedParamsGroups = $nestedParamsGroups;

        return $new;
    }

    public function withParamsGroup(string $paramsGroup): static
    {
        $new = clone $this;
        $new->paramsGroup = $paramsGroup;

        return $new;
    }

    public function withValidateEvents(bool $validateEvents): static
    {
        $new = clone $this;
        $new->validateEvents = $validateEvents;

        return $new;
    }

    public function withVendorPath(string $vendorPath): static
    {
        $new = clone $this;
        $new->vendorPath = $vendorPath;

        return $new;
    }

    public function withRootPath(string $rootPath): static
    {
        $new = clone $this;
        $new->rootPath = $rootPath;

        return $new;
    }

    /**
     * @throws ErrorException
     * @throws InvalidConfigException
     */
    protected function bootstrap(): void
    {
        $bootstrapList = $this->getConfiguration($this->bootstrapGroup);

        if ($bootstrapList === []) {
            return;
        }

        (new Bootstrap($this->getContainer(), $bootstrapList))->run();
    }

    /**
     * @throws ErrorException
     */
    protected function getConfiguration(string $name): array
    {
        return $this->getConfig()->has($name) ? $this->getConfig()->get($name) : [];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ErrorException
     * @throws NotFoundExceptionInterface
     */
    protected function validateEvents(): void
    {
        /** @var ListenerConfigurationChecker $listenerConfiguration */
        $listenerConfiguration = $this->get(ListenerConfigurationChecker::class);

        if ($this->validateEvents) {
            $listenerConfiguration->check($this->getConfiguration($this->eventsGroup));
        }
    }

    /**
     * @throws ErrorException
     */
    private function createDefaultConfig(): Config
    {
        $paramsGroups = [$this->paramsGroup, ...$this->nestedParamsGroups];
        $eventsGroups = [$this->eventsGroup, ...$this->nestedEventsGroups];

        return new Config(
            new ConfigPaths($this->rootPath, $this->configPath, $this->vendorPath),
            $this->environment,
            [
                ReverseMerge::groups(...$eventsGroups),
                RecursiveMerge::groups(...$paramsGroups, ...$eventsGroups),
            ],
            $this->paramsGroup,
        );
    }

    /**
     * @throws ErrorException
     * @throws InvalidConfigException
     */
    private function createDefaultContainer(): ContainerInterface
    {
        $containerConfig = ContainerConfig::create()->withValidate($this->debug);
        $containerConfig = $containerConfig
            ->withDefinitions($this->getConfiguration($this->diGroup))
            ->withDelegates($this->getConfiguration($this->diDelegatesGroup))
            ->withProviders($this->getConfiguration($this->diProvidersGroup))
            ->withTags($this->getConfiguration($this->diTagsGroup));

        $containerConfig = $containerConfig->withDefinitions(
            array_merge($containerConfig->getDefinitions(), [ConfigInterface::class => $this->getConfig()])
        );

        return new Container($containerConfig);
    }
}
