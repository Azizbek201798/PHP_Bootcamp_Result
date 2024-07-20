<?php
    require 'src/DB.php';
    require 'src/Todo.php';
    require 'bot/bot.php';

    if(isset($update)){
        require 'bot/bot.php';
        return;
    }

    $database = DB::connect();
    $todo = new Todo($database);
    $todos = $todo->getTodos();

    require 'view/view.php';

    require_once 'vendor/autoload.php';

    use GuzzleHttp\Client;
    
    $token = "7411716108:AAHie4mj97bbY6VWcUppRULe_aCOI7fCysY";
    $tgApi = "https://api.telegram.org/bot$token/";
    
    $client = new Client(['base_uri' => $tgApi]);
    
    $update = json_decode(file_get_contents('php://input'));
    
    if (isset($update->message)){
        $message = $update->message;
        $chat_id = $message->chat->id;
        $text = $message->text;
    
        if ($message->text === '/start')
        {
            $client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chat_id,
                    'text' => 'Assalomu aleykum',
                ]
            ]);
        } else if ($message->text === '/stop')
        {
            $client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chat_id,
                    'text' => 'Xayr',
                ]
            ]);
        } else if ($message->text === '/add')
        {
            $client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chat_id,
                    'text' => 'Please, enter your ',
                ]
            ]);
        } 
    }

