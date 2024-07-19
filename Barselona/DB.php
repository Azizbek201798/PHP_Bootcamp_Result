<?php

declare(strict_types=1);

class DB{

    public static function connect():PDO{
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=Workly", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());        
        };
        return $pdo;
    }

}