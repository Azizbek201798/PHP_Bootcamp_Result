<?php

declare(strict_types=1);

class Currency
{
    const API_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/USD/";

    private array $data;

    public function __construct()
    {
        $response = file_get_contents(self::API_URL);
        $this->data = json_decode($response, true);
    }

    public function getAmount (string $toConverter, float $amount): float
    {
        if ($toConverter == 'uzs') {
            return $amount * $this->data[0]['Rate'];
        }

        return $amount / $this->data[0]['Rate'];
    }
}
