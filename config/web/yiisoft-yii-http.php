<?php

declare(strict_types=1);

use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;
use Yiisoft\Yii\Http\Handler\NotFoundHandler;

/** @var array $params */

return [
    \Yiisoft\Yii\Http\Application::class => [
        '__construct()' => [
            'dispatcher' => DynamicReference::to(
                static fn (MiddlewareDispatcher $middlewareDispatcher) => $middlewareDispatcher->withMiddlewares(
                    $params['middlewares']
                ),
            ),
            'fallbackHandler' => $params['yiisoft/yii-http']['application'] ?? Reference::to(NotFoundHandler::class),
        ],
    ],
];
