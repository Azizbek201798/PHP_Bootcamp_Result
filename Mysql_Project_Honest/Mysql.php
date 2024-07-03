<?php

class Database {
    public $host;
    public $dbname;
    public $username;
    public $password;
    public $pdo;
    public $workDuration;
    public $total_workOffTime;
    
    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function fetchAllRows() {
        try {
            $query = "SELECT * FROM daily";
            $stmt = $this->pdo->query($query);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insertData($arrivedAt, $leavedAt) {
        try {
            $query = "INSERT INTO daily (arrived_at, leaved_at) VALUES (:arrivedAt, :leavedAt)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':arrivedAt', $arrivedAt);
            $stmt->bindValue(':leavedAt', $leavedAt);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$data = new Database('localhost','Workly','root','root');
$data->connect();

// Databasedan oldingi ma'lumotlarni olish;
$rows = $data->fetchAllRows();

// Databasedan oldingi ma'lumotlarni chiqarish;
echo "<ul>";

foreach ($rows as $row) {

    // echo $row['leaved_at']->diff($row['arrived_at']);
    $arrived_at = new DateTime($row['arrived_at']);
    $leaved_at = new DateTime($row['leaved_at']);
    $duration = $arrived_at->diff($leaved_at);
    echo "<li>ID: " . $row['id'] . ";  Arrived_At: " . $row['arrived_at'] . ";  Leaved_At: " . $row['leaved_at'] . "; Work Duration :" . $duration->format('%H:%I:%S') . "</li>";
}
echo "</ul>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arrivedAt = $_POST['arrived_at'];
    $leavedAt = $_POST['leaved_at'];

    $data->insertData($arrivedAt, $leavedAt);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Workly - Time Management</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #eab676;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #063970;
            border-radius: 5px;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #76b5c5;
            color: #191305;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif, sans-serif;
        }

        .form-group input[type="submit"]:hover {
            background-color: #76b5c5;
        }
    </style>
</head>
<body>
    <h1>Workly - Time Management</h1>

    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="arrived_at">Arrived At:</label>
                <input type="datetime-local" id="arrived_at" name="arrived_at" required>
            </div>

            <div class="form-group">
                <label for="leaved_at">Leaved At:</label>
                <input type="datetime-local" id="leaved_at" name="leaved_at" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>