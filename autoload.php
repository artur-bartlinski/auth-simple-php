<?php

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    $filePath = 'classes/' . end($parts) . '.php';
    if (file_exists($filePath)) {
        include $filePath;
    }
});
