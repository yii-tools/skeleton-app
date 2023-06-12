<?php

declare(strict_types=1);

use Yii\Service\ParameterInterface;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Csrf\CsrfTokenInterface;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Session\Flash\FlashInterface;
use Yiisoft\Translator\TranslatorInterface;

return [
    'yiisoft/view' => [
        'basePath' => '@views',
        'parameters' => [
            'assetManager' => Reference::to(AssetManager::class),
            'csrfToken' => Reference::to(CsrfTokenInterface::class),
            'currentRoute' => Reference::to(CurrentRoute::class),
            'flash' => Reference::to(FlashInterface::class),
            'parameter' => Reference::to(ParameterInterface::class),
            'translator' => Reference::to(TranslatorInterface::class),
            'urlGenerator' => Reference::to(UrlGeneratorInterface::class),
        ],
    ],
];
