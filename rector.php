<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/components',
        __DIR__ . '/controllers',
        __DIR__ . '/exceptions',
        __DIR__ . '/helpers',
        __DIR__ . '/interfaces',
        __DIR__ . '/views',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0);
