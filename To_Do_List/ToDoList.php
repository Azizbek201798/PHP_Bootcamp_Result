<?php

declare(strict_types=1);

class Task
{

    private PDO $pdo;

    function __construct(){
        $this->pdo = DB::connect();
    }

    public function add(string $text): bool 
    {
        $status = false;
        $stmt = $this->pdo->prepare("INSERT INTO ToDoList(name,checked) VALUES(:text,:status);");
        $stmt->bindParam(":name",$text);
        $stmt->bindParam(":checked",$status);
        return $stmt->execute();
    }

    public function getAll(){
        return $this->pdo->prepare("SELECT * FROM ToDoList;")->fetchAll();
    } 

}