<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$router = new Router();

if($router->isTelegramUpdate()){
    require 'routes/telegram.php';
    return;
}

require 'routes/web.php';