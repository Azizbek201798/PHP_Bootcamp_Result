<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$bot = new Bot($_ENV['TOKEN']);
$task = new Task(); 

$users = $bot->getAllUsers();

Router::get('/', require 'view/view.php');

Router::post('/', function () use ($task, $bot, $users) {
    if (isset($_POST['text'])) {
        $task->sendPost($_POST['text']);

        foreach ($users as $user) {
            $bot->sendPost($_POST['text'], $user['chat_id']);
        }
    }
});
