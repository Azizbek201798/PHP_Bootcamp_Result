<?php

declare(strict_types=1);


$task = new Task;

if(isset($_POST['text'])){
    $task->sendPost($_POST['text']);
}

Router::get('/',require 'view/view.php');