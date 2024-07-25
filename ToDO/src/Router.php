<?php

class Router{
    public $updates;
    public function __construct(){
        $this->updates = json_decode(file_get_contents("php://input"));
    }

    public function isApiCall()
    {
        $url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        $path = explode('/',$url);
        return array_search('api',$path);
    }

    public function getResourceId()
    {
        $url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        $path = explode('/',$url);
        $resourceId = $path[count($path) - 1];
        return is_numeric($resourceId ? (int)$resourceId : false);
    }

    public function isTelegramUpdate(){
        if(isset($this->updates->update_id)){
            return true;
        }
        return false;
    }

    public function getUpdates(){
        return $this->updates;
    }

    public function sendResponse($data){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }
}
