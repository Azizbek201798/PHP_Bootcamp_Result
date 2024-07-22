<?php

class Club{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    //
    public function getAll(){
        $stmt = $this->pdo->query("SELECT * FROM club")->fetchAll();
        return $stmt;
    }
        
    public function addItem($ism,$familiya,$jamoa,$mamlakat){
        $stmt = $this->pdo->prepare("INSERT INTO club(f_name,l_name,club_name,country) VALUES (?,?,?,?);");
        $stmt->bindParam(1,$ism);
        $stmt->bindParam(2,$familiya);
        $stmt->bindParam(3,$jamoa);
        $stmt->bindParam(4,$mamlakat);
        $stmt->execute();
    }
    
}
