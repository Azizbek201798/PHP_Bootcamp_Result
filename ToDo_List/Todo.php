<?php

class Todo{
    private $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function setToDo(string $toDoName){
        $status = false;
        $toDoName = trim($toDoName);
        $stmt = $this->pdo->prepare('INSERT INTO ToDoList(name,checked) VALUES(:text,:status);');
        $stmt->bindParam(':text',$toDoName);
        $stmt->bindParam(':status',$status,PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function getToDo(){
        return $this->pdo->query("SELECT * FROM ToDoList")->fetchAll(PDO::FETCH_ASSOC);
    }
    
}