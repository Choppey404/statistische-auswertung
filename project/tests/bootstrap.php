<?php

declare(strict_types=1);

if (\array_key_exists('BOOTSTRAP_CACHE_CLEAR', $_ENV) && $_ENV['BOOTSTRAP_CACHE_CLEAR'] === '1') {
    \passthru(\sprintf(
        'php "%s/../bin/console" cache:clear -e test --no-warmup',
        __DIR__
    ));
}
if (\array_key_exists('BOOTSTRAP_DELETE_SQLITE', $_ENV) && $_ENV['BOOTSTRAP_DELETE_SQLITE'] === '1') {
    \passthru(\sprintf(
        'rm -rf %s/../var/cache/test',
        __DIR__
    ));
}
require __DIR__ . '/../config/bootstrap.php';
