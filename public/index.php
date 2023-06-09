<?php

declare(strict_types=1);

use Yii\Framework\Runner\HttpApplication;

/**
 * @psalm-var string $_SERVER['REQUEST_URI']
 *
 * PHP built-in server routing.
 */
if (PHP_SAPI === 'cli-server') {
    /**
     * @psalm-suppress MixedArgument
     *
     * Serve static files as is.
     */
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false;
    }

    /**
     * Explicitly set for URLs with dot.
     */
    $_SERVER['SCRIPT_NAME'] = '/index.php';
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Run HTTP application runner
 */
(new HttpApplication())->withDebug(false)->withRootPath(dirname(__DIR__))->run();
