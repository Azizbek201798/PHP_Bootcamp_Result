<?php

use GuzzleHttp\Client;

class Bot{
    const TOKEN = '7411716108:AAHie4mj97bbY6VWcUppRULe_aCOI7fCysY';
    const API_URL = 'https://api.telegram.org/bot' . self::TOKEN . '/';

    private $http;

    public function __construct(){
        $this->http = new Client(['base_uri'=>self::API_URL]);
    }

    public function startHandlerCommand(string $chat_id){
        $this->http->post('sendMessage',[
            'form_params'=>[
                'chat_id'=>$chat_id,
                'text'=>'Azizbek nima gap?',
            ]
            ]);
    }

    public function addHandlerCommand(string $chat_id){
        $this->http->post('sendMessage',[
            'form_params'=>[
                'chat_id'=>$chat_id,
                'text'=>'Enter your text : ',
            ]
            ]);
    }
}