<?php

declare(strict_types=1);

class DB
{

    protected $pdo;

    public function __construct(){
        return $this->pdo = new PDO('msql:host=localhost;dbname=Workly','root','root');
    }
    
}
