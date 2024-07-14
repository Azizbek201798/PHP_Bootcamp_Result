<?php

declare(strict_types=1);

require 'Currency.php';

class SaveUsersData
{
    private PDO $pdo;
    private Currency $bot;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'Workly';
        $username = 'root';
        $password = 'root';

        $this->bot = new Currency();

        try {
            $this->pdo = new PDO(
                "mysql:host={$host};dbname={$dbname}",
                $username,
                $password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function saveuser (int $user_chat_id, string $user_callback_data): void
    {
        $query = "INSERT INTO saveuser (user_chat_id, user_callback_data, user_data_time) VALUES (:user_chat_id, :user_callback_data, :user_data_time)";
        $now = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_chat_id', $user_chat_id);
        $stmt->bindParam(':user_callback_data', $user_callback_data);
        $stmt->bindParam(':user_data_time', $now);
        $stmt->execute();
    }

    public function getuser (float $amount, int $user_chat_id): string
    {
        $query = "SELECT user_callback_data FROM saveuser WHERE user_chat_id = :user_chat_id ORDER BY user_data_time DESC LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_chat_id', $user_chat_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return 'Error: No conversion data found.';
        }

        $stateName = $result['user_callback_data'];
        $toConverter = explode("2", $stateName);

        $response = $this->bot->getAmount($toConverter[1], $amount);

        return sprintf("Converted amount: %.2f", $response);
    }

    public function allusersinfo(int $user_chat_id, string $user_convertion_type, float $user_amount): void
    {
        $query = "INSERT INTO usersinfo (user_chat_id, user_convertion_type, user_amount, user_data_time) VALUES (:user_chat_id, :user_convertion_type, :user_amount, :user_data_time)";
        $now = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_chat_id', $user_chat_id);
        $stmt->bindParam(':user_convertion_type', $user_convertion_type);
        $stmt->bindParam(':user_amount', $user_amount);
        $stmt->bindParam(':user_data_time', $now);
        $stmt->execute();
    }

    public function sendConvertionType(int $user_chat_id): ?string
    {
        $query = "SELECT user_callback_data FROM saveuser WHERE user_chat_id = :user_chat_id ORDER BY user_data_time DESC LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_chat_id', $user_chat_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['user_callback_data'] ?? null;
    }

    public function sendAllUsersInfo(): array
    {
        $query = "SELECT * FROM usersinfo";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}
