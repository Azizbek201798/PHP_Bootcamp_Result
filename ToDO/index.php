<?php
    require 'vendor/autoload.php';

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require 'bootstrap.php';
    require 'routes/api.php';
    require 'routes/telegram.php';
    require 'routes/web.php';