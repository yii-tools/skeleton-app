<?php

declare(strict_types=1);

return [
    'yiisoft/aliases' => [
        'aliases' => [
            '@root' => dirname(__DIR__, 2),
            '@assets' => '@public/assets',
            '@assetsUrl' => '@baseUrl/assets',
            '@baseUrl' => '/',
            '@npm' => '@root/node_modules',
            '@public' => '@root/public',
            '@resources' => '@root/src/Framework/resources',
            '@runtime' => '@root/runtime',
            '@vendor' => '@root/vendor',
            '@views' => '@root/resources/views',
        ],
    ],
];
