<?php
    require 'vendor/autoload.php';
    require 'src/DB.php';
    require 'src/Todo.php';
$user = new User();

date_default_timezone_set("Asia/Tashkent");
$database = DB::connect();
$todo = new Todo($database);
$todos = $todo->getTodos();
$update = json_decode(file_get_contents('php://input'));

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

// API namuna->;
if(isset($update)){
    if(isset($update->update_id)){
        require 'bot/bot.php';
        return;
    }elseif($path === '/add'){
        $todo->addTodo($update->text);
        return;
    }elseif($path === '/getall'){
        print_r($user->getAllUsers());
        return;
    }elseif($path === '/delete'){
        $user->delete($update->message->text - 1);
        return;
    }elseif($path === '/check'){
        $user->check($update->message->text - 1);
    }elseif($path === '/uncheck'){
        $user->uncheck($update->message->text - 1);
    }
}

require 'index.php';
