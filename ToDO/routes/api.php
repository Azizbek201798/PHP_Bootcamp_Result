<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$router = new Router();
$db = DB::connect();
$todo = new Todo($db);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if($router->isApiCall()){

    if($requestMethod == 'GET'){
        $router->sendResponse($todo->getTodos());
        return;
    } // DONE;
    
    if($requestMethod == 'POST'){
        if(!isset($router->getUpdates()->text)){
            $router->sendResponse([
                'message' => 'text is not found',
                'code' => 403,
            ]);
            return;
        }

        $todo->addTodo($router->getUpdates()->text);
        $res = $todo ? "Added to database" : "Something went wrong";
        $router->sendResponse($res);
        return;        
    } // DONE;

    if($requestMethod == 'PATCH'){
        $id = $router->getUpdates()->taskId;
        if(!isset($id) && $todo->checkId($id)){
            $router->sendResponse([
                'message' => 'Id not found',
                'code' => 403,
            ]);
        }
        $todo->changeStatus($id);
        return;
    }   // DONE;

    if($requestMethod == 'DELETE'){
        $id = $router->getUpdates()->taskId;
        if(!$id){
            $router->sendResponse([
                'message' => 'id not found',
                'code' => 403,
            ]);
        }
        $todo->deleteTodo($id);
        return;
    }
    // DONE;
}