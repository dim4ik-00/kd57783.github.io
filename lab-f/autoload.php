<?php

spl_autoload_register(function ($class) {

    $prefix = 'App\\';

    $baseDir = __DIR__ . '/lib/';

    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));

    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});