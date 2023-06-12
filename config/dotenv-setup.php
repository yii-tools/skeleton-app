<?php

declare(strict_types=1);

use Dotenv\Dotenv;

function loadEnvVariables(string $directory): void
{
    $dotenv = Dotenv::createImmutable($directory);
    $dotenv->load();
}

function setEnvironmentVariables(): void
{
    $envDirectory = __DIR__;

    if (file_exists($envDirectory . '/.env')) {
        loadEnvVariables($envDirectory);
    }

    $_ENV['YII_ENV'] = $_ENV['YII_ENV'] ?? null;
    $_SERVER['YII_ENV'] = $_ENV['YII_ENV'];

    $_ENV['YII_DEBUG'] = filter_var(
        $_ENV['YII_DEBUG'] ?? true,
        FILTER_VALIDATE_BOOLEAN,
        FILTER_NULL_ON_FAILURE
    ) ?? true;
    $_SERVER['YII_DEBUG'] = $_ENV['YII_DEBUG'];
}
