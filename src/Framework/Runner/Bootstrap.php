<?php

declare(strict_types=1);

namespace Yii\Framework\Runner;

use Psr\Container\ContainerInterface;
use RuntimeException;

use function get_debug_type;
use function is_callable;
use function sprintf;

/**
 * Runs application bootstrap configs.
 */
final class Bootstrap implements Runner
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly array $bootstrapList = []
    ) {
    }

    /**
     * @throws RuntimeException If the bootstrap callback is not callable.
     */
    public function run(): void
    {
        foreach ($this->bootstrapList as $callback) {
            if (!is_callable($callback)) {
                throw new RuntimeException(
                    sprintf('Bootstrap callback must be callable, "%s" given.', get_debug_type($callback))
                );
            }

            $callback($this->container);
        }
    }
}
