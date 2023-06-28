<?php

declare(strict_types=1);

use HttpSoft\ServerRequest\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

return [
    ServerRequestInterface::class => ServerRequestCreator::create(),
];
