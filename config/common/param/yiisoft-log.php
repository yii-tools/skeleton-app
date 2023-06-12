<?php

declare(strict_types=1);

use Yiisoft\Log\Target\File\FileTarget;

return [
    'yiisoft/log' => [
        'targets' => [
            FileTarget::class,
        ],
    ],
];
