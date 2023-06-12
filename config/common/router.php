<?php

declare(strict_types=1);

use Yiisoft\Config\Config;
use Yiisoft\DataResponse\Middleware\FormatDataResponse;
use Yiisoft\Csrf\CsrfMiddleware;
use Yiisoft\Router\Group;
use Yiisoft\Router\RouteCollection;
use Yiisoft\Router\RouteCollectionInterface;
use Yiisoft\Router\RouteCollector;
use Yiisoft\Router\RouteCollectorInterface;

/** @var Config $config */

return [
    RouteCollectorInterface::class => static fn (
        RouteCollector $routeCollector
    ): RouteCollectorInterface => $routeCollector
        ->middleware(CsrfMiddleware::class)
        ->middleware(FormatDataResponse::class)
        ->addGroup(Group::create('/{_language}')->routes(...$config->get('routes'))),

    RouteCollectionInterface::class => static fn (
        RouteCollectorInterface $routeCollector
    ):RouteCollection => new RouteCollection($routeCollector),
];
