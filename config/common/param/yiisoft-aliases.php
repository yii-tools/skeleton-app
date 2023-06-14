<?php

declare(strict_types=1);

return [
    'yiisoft/aliases' => [
        'aliases' => [
            '@app' => dirname(__DIR__, 2),
            '@assets' => '@public/assets',
            '@assetsUrl' => '@baseUrl/assets',
            '@baseUrl' => '/',
            '@messages' => '@resources/messages',
            '@npm' => '@root/node_modules',
            '@public' => '@root/public',
            '@resources' => '@root/src/Framework/resources',
            '@runtime' => '@root/runtime',
            '@vendor' => '@root/vendor',
            '@views' => '@resources/views',
        ],
    ],
];
