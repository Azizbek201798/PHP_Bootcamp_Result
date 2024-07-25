<?php

    require 'vendor/autoload.php';
    require 'src/DB.php';
    require 'src/Todo.php';
    require 'routes/routes.php';
    require 'bootstrap.php';


// $path = parse_url($_SERVER['REQUEST_URI'])['path'];

// // API namuna->;
// if(isset($update)){
//     if(isset($update->update_id)){
//         require 'bot/bot.php';
//         return;
//     }elseif($path === '/add'){
//         $todo->addTodo($update->text);
//         return;
//     }elseif($path === '/getall'){
//         print_r($todo->getTodos());
//         return;
//     }elseif($path === '/delete'){
//         $todo->deleteTodo($update->message->text - 1);
//         return;
//     }elseif($path === '/check'){
//         $todo->toggleTodoStatus($update->message->text - 1);
//     }
// }

