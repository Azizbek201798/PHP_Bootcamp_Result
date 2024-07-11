<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$token = "7284381414:AAHv-6aSoVU2c98Z3MQug0WuEotG_qPt75o";
$tgApi = "https://api.telegram.org/bot$token/";

$client = new Client(['base_uri' => $tgApi]);
$currency = new Client(['base_uri' => 'https://cbu.uz/oz/arkhiv-kursov-valyut/json/']);

$update = json_decode(file_get_contents('php://input'), true);

if (isset($update)) {
    if (isset($update['message'])) {
        $message = $update['message'];
        $chat_id = "5646244166";
        $message_id = $message['message_id'];
        $text = $message['text'];

        $exp = explode('-', $text);
        $currencyCode = strtoupper($exp[1]);

        $response = $currency->get('');
        $data = json_decode($response->getBody()->getContents(), true);

        $convertedAmount = '';
        foreach ($data as $current) {
            if ($current['Ccy'] === $currencyCode && $current['Rate'] !== 0) {
                $convertedAmount = round((float)$exp[0] / (float)$current['Rate'], 2);
                break;
            }
        }

        if ($convertedAmount !== '') {
            $responseText = "1-$currencyCode = $convertedAmount-$exp[1]";
        } else {
            $responseText = "Sorry, the conversion rate for $currencyCode is not available.";
        }

        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $responseText,
            ],
        ]);
    }
}
?>