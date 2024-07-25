<?php

    require 'vendor/autoload.php';

    $update = json_decode(file_get_contents('php://input'),true);

    require 'bootstrap.php';
    require 'routes/api.php';
    require 'routes/telegram.php';