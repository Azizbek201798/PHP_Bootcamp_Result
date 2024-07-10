<?php

declare(strict_types=1);
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$token = "7284381414:AAHv-6aSoVU2c98Z3MQug0WuEotG_qPt75o";
$tgApi = "https://api.telegram.org/bot$token/";

$client = new Client([
    'base_uri' => $tgApi,
]);

$responce = $client->post('getUpdates',[
    'form_params' => [
        'chat_id' => '5646244166',
        'text' => 'Epam',
    ]
]);

$json = $responce->getBody()->getContents();
print_r(json_decode($json,true));

?>