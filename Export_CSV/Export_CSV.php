<?php

class Workly {

    public $username;
    public $password;
    public $dbname;
    public $host;
    public $pdo;

    public function __construct($username, $password, $dbname, $host) {
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->host = $host;
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

    public function exportData() {
        try {
            // Fetch all rows from the 'daily' table
            $query = "SELECT * FROM daily";
            $stmt = $this->pdo->query($query);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Set headers for CSV download
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=workly_data.csv');

            // Open a file pointer connected to php://output
            $output = fopen('php://output', 'w');

            // Write headers to the CSV file
            fputcsv($output, ['Arrived at', 'Leaved at', 'Required work off', 'Worked off']);

            // Loop through rows and write each row to the CSV
            foreach ($rows as $row) {
                $arrived_at = new DateTime($row['arrived_at']);
                $leaved_at = new DateTime($row['leaved_at']);
                $requiredWorkHours = DateTime::createFromFormat('H:i:s', '09:00:00');
                $debtInSeconds = $row['required_work'];

                // Format the required work in hours and minutes
                $requiredWork = ($debtInSeconds > 0) ? gmdate('H:i', $debtInSeconds) : '0 min';

                // Determine worked off status
                $workedOff = ($row['worked_off'] == 1) ? 'Yes' : 'No';

                // Write row data to CSV
                fputcsv($output, [
                    $arrived_at->format('Y-m-d H:i:s'),
                    $leaved_at->format('Y-m-d H:i:s'),
                    $requiredWork,
                    $workedOff
                ]);
            }

            // Close file pointer
            fclose($output);

            // Terminate script after download
            exit();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Initialize Workly object and connect to database
$data = new Workly('root', 'root', 'Workly', 'localhost');
$data->connect();

// Handle export request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['export'])) {
    $data->exportData();
}

// Fetch all rows from the 'daily' table
$rows = $data->fetchAllRows();

?>
<!DOCTYPE html>
<html>
<head>
    <title>PWOT - Personal Work Off Tracker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-10">PWOT - Personal Work Off Tracker</h1>

    <form method="post" action="" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="arrived_at">Arrived at</label>
                <input type="datetime-local" class="form-control" name="arrived_at" required>
            </div>
            <div class="form-group col-md-4">
                <label for="leaved_at">Leaved at</label>
                <input type="datetime-local" class="form-control" name="leaved_at" required>
            </div>
            <div class="form-group col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <span style="margin-left: 30px;"></span>
                <a href="?export=true" class="btn btn-primary ml-2">Export</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Arrived at</th>
                <th>Leaved at</th>
                <th>Required work off</th>
                <th>Worked off</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($rows)) : ?>
        <?php foreach ($rows as $index => $row) : ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $row['arrived_at']; ?></td>
                <td><?php echo $row['leaved_at']; ?></td>
                <td><?php echo $row['required_work']; ?></td>
                <td><?php echo ($row['worked_off'] == 1) ? 'Yes' : 'No'; ?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
