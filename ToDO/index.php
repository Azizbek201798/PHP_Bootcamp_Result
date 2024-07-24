<?php
    require 'vendor/autoload.php';
    require 'src/DB.php';
    require 'src/Todo.php';
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
        print_r($todo->getTodos());
        return;
    }elseif($path === '/delete'){
        $todo->deleteTodo($update->update_id);
        return;
}

}

require 'index.php';
