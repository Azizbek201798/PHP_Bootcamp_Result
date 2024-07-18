<?php

require 'DB.php';
require 'Todo.php';

$pdo = DB::connect();

$todo = new Todo($pdo);

require 'view.php';

if(!empty($_POST)){
    print_r($_POST);
}
