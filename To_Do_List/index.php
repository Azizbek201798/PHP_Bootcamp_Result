<?php

require_once 'vendor/autoload.php';
require 'ToDoList.php';
require 'DB.php';

$task = new Task();
if(isset($_POST['text'])){
     $task->add($_POST['text']);
}

require 'view.php';
