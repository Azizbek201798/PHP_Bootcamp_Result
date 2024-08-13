<?php

use GuzzleHttp\Client;

class Bot{
    public string $api;
    public PDO $pdo;
    public Client $http;

    public function __construct(string $token)
    {
        $this->api = "https://api.telegram.org/bot{$token}/";
        $this->http = new Client(['base_uri' => $this->api]);
        $this->pdo  = DB::connect();
    }

    public function handlerStartCommand(int $chatId){
        $stmt = $this->pdo->prepare("INSERT INTO users (chat_id) VALUES(:chatId);");
        $stmt->bindParam(":chatId",$chatId);
        $stmt->execute();        
    }

    public function getAllUsers(){
        $stmt = $this->pdo->query("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();        
    }

    public function sendPost($post,$chatId){
        $this->http->post('sendMessage',[
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $post,
            ]
            ]);
    }

}