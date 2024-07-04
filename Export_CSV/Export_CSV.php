<?php

class Workly {

    public $username;
    public $password;
    public $dbname;
    public $host;
    public $pdo;
    public $total;

    public function __construct($username, $password, $dbname, $host) {
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->host = $host;
    }

    public function calculateTotal() {
        try {
            $query = "SELECT SUM(required_work) as total FROM daily WHERE worked_off = 1";
            $stmt = $this->pdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->total = $result['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
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
            $query = "SELECT * FROM daily";
            $stmt = $this->pdo->query($query);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=workly_data.csv');

            $output = fopen('php://output', 'w');

            fputcsv($output, ['Arrived at', 'Leaved at', 'Required work off', 'Worked off']);

            $total = 0;

            foreach ($rows as $row) {
            
                $arrived_at = new DateTime($row['arrived_at']);
                $leaved_at = new DateTime($row['leaved_at']);
                $debtInSeconds = $row['required_work'];

                if ($row['worked_off'] = 1){
                    $total += $row['required_work'];
                }

                $requiredWork = ($debtInSeconds > 0) ? gmdate('H:i', $debtInSeconds) : '0 min';

                $workedOff = ($row['worked_off'] == 1) ? 'Yes' : 'No';

                fputcsv($output, [
                    $arrived_at->format('Y-m-d H:i:s'),
                    $leaved_at->format('Y-m-d H:i:s'),
                    $requiredWork,
                    $workedOff
                ]);
            }

            $this->total = $total;

            fclose($output);
            exit();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$data = new Workly('root', 'root', 'Workly', 'localhost');
$data->connect();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['export'])) {
    $data->exportData();
}

$rows = $data->fetchAllRows();
$data->calculateTotal();

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
                <td>
                    <?php

                        if ($row['required_work'] >= 3060){
                            echo ( (int)($row['required_work'] / 3600) . " hours " . (int)($row['required_work'] % 3060) / 60 . " mins"); 
                        } else {
                            echo (int)($row['required_work'] % 3060) / 60 . " mins";
                        }
                        
                    ?>
                </td>
                <td>
                    <?php if ($row['worked_off'] == 1) :  ?>
                        <button type="button" class="btn btn-primary">Done</button>
                    <?php else : ?>
                        <input type="checkbox" checked disabled>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        
        
        <?php endif; ?>
        </tbody>
    </table>

    <h4> <?php echo "Total work of time : " . ( (int)($data->total / 3600) . " hours " . (int)($data->total % 3060) / 60 . " mins") ?> </h4>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
