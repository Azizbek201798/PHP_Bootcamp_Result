<?php

class DB{
    public $pdo;
    public function __construct(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=Workly;","root","root");
    }
}

header("Content-Type:JSON");
$database = new DB();
$result = $database->pdo->query("SELECT * FROM api;")->fetchall();
var_dump($result);