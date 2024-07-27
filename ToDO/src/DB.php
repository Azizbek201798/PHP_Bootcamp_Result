<?php
declare(strict_types=1);

require 'vendor/autoload.php';

class DB
{
    public static function connect(): PDO
    {
        $pdo = new PDO(
            "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
            $_ENV["DB_NAME"],
            $_ENV['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
        return $pdo;
    }
}