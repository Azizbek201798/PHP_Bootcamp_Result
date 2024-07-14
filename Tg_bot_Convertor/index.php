<?php

declare(strict_types=1);

require 'vendor/autoload.php';
require 'SaveUsersData.php';
date_default_timezone_set('Asia/Tashkent');

use GuzzleHttp\Client;

$token = "7284381414:AAHv-6aSoVU2c98Z3MQug0WuEotG_qPt75o";
$tgApi = "https://api.telegram.org/bot$token/";

$client = new Client(['base_uri' => $tgApi]);

$update = json_decode(file_get_contents('php://input'));

$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => '🇺🇸 <=> 🇺🇿', 'callback_data' => 'usd2uzs'],
            ['text' => '🇺🇿 <=> 🇺🇸', 'callback_data' => 'uzs2usd'],
        ],
    ]
];

$saveuser = new SaveUsersData();

if (isset($update->message))
{
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    if ($text === '/start')
    {
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Select an exchange rate',
                'reply_markup' => json_encode($keyboard)
            ]
        ]);
    }

    if (is_numeric($text))
    {
        $conversionType = $saveuser->sendConvertionType($chat_id);
        if ($conversionType) {
            $saveuser->allusersinfo($chat_id, $conversionType, (float)$text);
            $client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chat_id,
                    'text' => $saveuser->getuser((float)$text, $chat_id)
                ]
            ]);
        } else {
            $client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chat_id,
                    'text' => 'Error: No conversion type found.'
                ]
            ]);
        }
    }

}

if (isset($update->callback_query)) {
    $callback_query = $update->callback_query;
    $chat_id        = $callback_query->message->chat->id;
    $callback_data  = $callback_query->data;

    $saveuser->saveuser($chat_id, $callback_data);

    $client->post('sendMessage', [
        'form_params' => [
            'chat_id' => $chat_id,
            'text' => 'Enter the amount:'
        ]
    ]);
}
