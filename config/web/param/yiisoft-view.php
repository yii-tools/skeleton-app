<?php

declare(strict_types=1);

use Yii\Service\ParameterInterface;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Csrf\CsrfTokenInterface;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Session\Flash\FlashInterface;
use Yiisoft\Translator\TranslatorInterface;
use Yii\Middleware\LocaleRouteHelper;

return [
    'yiisoft/view' => [
        'basePath' => '@views',
        'parameters' => [
            'assetManager' => Reference::to(AssetManager::class),
            'csrfToken' => Reference::to(CsrfTokenInterface::class),
            'localeRouteHelper' => Reference::to(LocaleRouteHelper::class),
            'flash' => Reference::to(FlashInterface::class),
            'parameter' => Reference::to(ParameterInterface::class),
            'translator' => Reference::to(TranslatorInterface::class),
            'urlGenerator' => Reference::to(UrlGeneratorInterface::class),
        ],
    ],
];
