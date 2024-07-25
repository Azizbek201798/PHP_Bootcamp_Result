<?php

    require 'vendor/autoload.php';

    $update = json_decode(file_get_contents('php://input'),true);

    if(isset($update->message)){
        if (isset($update->update_id)){
        require 'bot/bot.php';
        return;
       }
    }

    require 'bootstrap.php';
    require 'routes/api.php';