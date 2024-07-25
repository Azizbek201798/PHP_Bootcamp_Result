<?php

class Router{
    public $updates;
    public function __construct(){
        $this->updates = json_decode(file_get_contents("php://input"));
    }

    public function isApiCall(){
        $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        $path = explode('/',$uri);
        return array_search('api',$path);
    }

    public function getResourceId(){
        
    }


}