<?php

if (isset($update->message)){
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    $bot = new Bot();
    $todo = new Todo();
    $user = new User();

    if ($text === '/start')
    {
        $user->save_user($chat_id);
        $bot->startHandlerCommand($chat_id);
    }
 
    if ($message->text === '/add')
    {
        $bot->addHandlerCommand($chat_id);
    }
    
}