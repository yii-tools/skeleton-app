<?php

declare(strict_types=1);

use Yii\Middleware\Locale;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Router\Middleware\Router;
use Yiisoft\Session\SessionMiddleware;

return [
    'middlewares' => [
        ErrorCatcher::class,
        SessionMiddleware::class,
        Locale::class,
        Router::class,
    ],
];
