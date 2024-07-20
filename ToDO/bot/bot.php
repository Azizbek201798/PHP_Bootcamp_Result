<?php

if (isset($update->message)){
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    $bot = new Bot();
    // $user = new User();

    if ($message->text === '/start')
    {
        $user->save_user($chat_id);
        $bot->startHandlerCommand($chat_id);
    }
 
    if ($message->text === '/add')
    {
        $bot->addHandlerCommand($chat_id);
    }
    
}