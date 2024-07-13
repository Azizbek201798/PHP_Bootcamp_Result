<?php

use GuzzleHttp\Client;

class BotHandler{

    const TOKEN = "7284381414:AAHv-6aSoVU2c98Z3MQug0WuEotG_qPt75o";
    const API = "https://api.telegram.org/bot".self::TOKEN."/";
    public Client $http;

    public function __construct(){
        $this->http = new Client(['base_uri' => self::API]);
    }

    public function handleStartCommand(int $chatId){
        $this->http->post('sendMessage',[
            'form_params' => [
                'chat_id' => $chatId,
                'text' => 'Welcome to Currency Convertor bot.',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'UZD > UZS','callback_data' => 'usd:uzs'],
                            ['text' => 'UZS > USD', 'callback_data' => 'uzs:usd'],
                        ]
                    ]
                ])
            ]
        ]);
    }
}

?>