<?php

$autoloadFile = __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

if(!file_exists($autoloadFile)) {
    echo 'The dependencies not installed! (Auto-load file not found!)';
    exit(1);
}

include_once $autoloadFile;
