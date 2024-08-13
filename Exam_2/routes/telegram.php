<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$updates = json_decode(file_get_contents('php://input'));

$bot = new Bot($_ENV['TOKEN']);
$router = new Router();

$users = $bot->getAllUsers();

if(isset($updates->message)){
    $message = $updates->message;
    $chatId = $message->chat->id;
    $text = $message->text;

    if($text === "/start"){
        $bot->handlerStartCommand($chatId);
        return;
    }
}