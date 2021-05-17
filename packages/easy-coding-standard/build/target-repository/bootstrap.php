<?php

declare(strict_types=1);

// inspired by https://github.com/phpstan/phpstan/blob/master/bootstrap.php

spl_autoload_register(function (string $class): void {
    static $composerAutoloader;

    // already loaded in bin/ecs.php
    if (defined('__ECS_RUNNING__')) {
        return;
    }

    // load prefixed or native class, e.g. for running tests
    if (strpos($class, 'ECSPrefix') === 0 || strpos($class, 'Symplify\\') === 0) {
        if ($composerAutoloader === null) {
            // prefixed version autoload
            $composerAutoloader = require __DIR__ . '/vendor/autoload.php';
        }
        $composerAutoloader->loadClass($class);
    }
});
