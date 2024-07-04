<?php

class Workly {

    public $username;
    public $password;
    public $dbname;
    public $host;
    public $pdo;
    public $total_debt;
    public $total;

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

    public function fetchAllRows($page = 1 , $limit) {
        try {
            $offset = ($page - 1) * $limit;
            $query = "SELECT * FROM daily LIMIT $offset,$limit;";
            $stmt = $this->pdo->query($query);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

  public function updateWorkedOff($id) {
    try {
        $query = "UPDATE daily SET worked_off = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

    public function insertData($arrivedAt, $leavedAt, $requiredWork, $workedOff) {
        try {
            $query = "INSERT INTO daily (arrived_at, leaved_at, required_work, worked_off) VALUES (:arrivedAt, :leavedAt, :requiredWork, :workedOff);";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":arrivedAt", $arrivedAt->format('Y-m-d H:i:s')); 
            $stmt->bindValue(":leavedAt", $leavedAt->format('Y-m-d H:i:s'));
            $stmt->bindValue(":requiredWork", $requiredWork);
            $stmt->bindValue(":workedOff", $workedOff);
            $stmt->execute();
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

$data = new Workly('root','root','Workly','localhost');
$data->connect();

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$limit = 5;
$totalRows = count($data->fetchAllRows(1, $limit)); 
$totalPages = ceil($totalRows / $limit); 
$rows = $data->fetchAllRows($page, $limit);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['export'])) {
    $data->exportData();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $arrivedAt = new DateTime($_POST['arrived_at']);
    $leavedAt = new DateTime($_POST['leaved_at']);
    
    if ($leavedAt < $arrivedAt) {
        
        $requiredWork = 0;
    
    } else {
        $duration = $leavedAt->getTimestamp() - $arrivedAt->getTimestamp();;
        $intervalInSeconds = $duration;
        
        if ($intervalInSeconds > 32400){
            $requiredWork = 0;
        } else {
            $requiredWork = 32400 - $intervalInSeconds;
        }
    }

    if ($requiredWork > 0) {
        $workedOff = 1;
    } else {
        $workedOff = 0;
    }

    $data->insertData($arrivedAt, $leavedAt, $requiredWork, $workedOff);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();

}

if (isset($_GET['daily_id'])) {
    $id = $_GET['daily_id'];
    $data->updateWorkedOff($id);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

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
            <a href="?export=true" class="btn btn-success ml-2">Export as CSV</a>
        </div>
        </div>
    </form>

    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>

    <table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Arrived at</th>
            <th>Leaved at</th>
            <th>Required work off</th>
            <th>Worked off</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($rows)) : ?>
    <?php
    
    $total_debt = 0;

    foreach ($rows as $index => $row) {

        $arrived_at = new DateTime($row['arrived_at']);
        $leaved_at = new DateTime($row['leaved_at']);
        $requiredWorkHours = DateTime::createFromFormat('H:i:s', '09:00:00');
        $debtInSeconds = $row['required_work'];

        if ($row['worked_off'] == 1){
            $total_debt += $row['required_work'];
        }

        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $arrived_at->format('Y-m-d H:i:s'); ?></td>
            <td><?php echo $leaved_at->format('Y-m-d H:i:s'); ?></td>
            <td><?php
                if ($debtInSeconds > 0) {
                    if (($debtInSeconds / 60) >= 60) {
                        echo (int)($debtInSeconds / 3600) . ' hours and ' . (int)(($debtInSeconds % 3600) / 60) . " min";
                    } else {
                        echo (int)($debtInSeconds / 60) . " min";
                    }
                } else {
                    echo "0 min.";
                }
                ?></td>
            <td>
            <?php if ($row['worked_off']) : ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']; ?>">
                    Done
                    </button>

                    <div class="modal fade" id="exampleModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you Sure?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <form action="./Export_CSV.php" method="get">
                                <input type="text" name="daily_id" value="<?php echo $row['id']; ?>">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </form>
                            
                        </div>
                        </div>
                    </div>
                    </div>
                <?php else : ?>
                    <input type="checkbox" checked disabled>
                <?php endif; ?>
            </td>
        </tr>
    <?php } ?>
        <?php endif; ?>
    </tbody>
</table>
    <h5>Total Work Of Time : <?php echo (int)($total_debt / 3600) . ' hours and ' . (int)(($total_debt%3600) / 60) . " min"?> </h5>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>