<?php

declare(strict_types=1);

return [
    'config-plugin' => [
        // configuration Yii Tools
        'application-params' => '?application-params.php',

        // configuration Yii3
        'params' => ['common/param/*.php'],
        'params-web' => [
            '$params',
            'web/param/*.php',
        ],
        'params-console' => [
            '$params',
            'console/param/*.php',
        ],
        'di' => [
            'common/*.php',
        ],
        'di-web' => [
            '$di',
            'web/*.php',
        ],
        'di-console' => [
            '$di',
            'console/*.php',
        ],
        'bootstrap' => '?bootstrap.php',
        'bootstrap-web' => '?web/bootstrap',
        'bootstrap-console' => '?console/bootstrap',
        'events' => [],
        'events-web' => ['$events'],
        'events-console' => ['$events'],
        'routes' => 'routes.php',
    ],
    'config-plugin-options' => [
        'source-directory' => 'config',
    ],
];
