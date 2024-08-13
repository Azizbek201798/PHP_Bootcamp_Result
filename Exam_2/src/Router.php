<?php

declare(strict_types=1);

class Router{
    public $updates;

    public function __construct(){
        $this->updates = json_decode(file_get_contents('php://input'));
    }

    public static function get($path,$callback){
        
        if($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $path){
            $callback();
        }

    }
    public static function post($path,$callback){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === $path){
            $callback();
        }
        
    }
    public function isTelegramUpdate(){
        if(isset($this->updates->update_id)){
            return true;
        }
        return false;
    }

}