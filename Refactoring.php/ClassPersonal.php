<?php

class PersonalWorkOffTracker {

    private $conn;

    public function __construct() {
        $this->conn = new PDO('mysql:host=localhost;dbname=Workly', 'root', 'root');
    }

    public function addRecord($arrived_at, $leaved_at) {
        $arrived_at_dt = new DateTime($arrived_at);
        $leaved_at_dt = new DateTime($leaved_at); 
        $worked_off = null;

        $interval = $arrived_at_dt->diff($leaved_at_dt);
        $seconds = $interval->s;
        var_dump($seconds);
        $required_work = $seconds;

        if($required_work > 32400){
            $worked_off = 0;
        } else {
            $worked_off = 1;
        }


        $sql = "INSERT INTO daily (arrived_at, leaved_at, required_work, worked_off) VALUES (:arrived_at, :leaved_at, :required_work, :worked_off)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':arrived_at', $arrived_at);
        $stmt->bindParam(':leaved_at', $leaved_at);
        $stmt->bindParam(':required_work', $required_work);
        $stmt->bindParam(':worked_off', $worked_off);

        $stmt->execute();
    }

    public function fetchRecords($page_id) {
        $offset = ($page_id - 1) * 5;
        $sql = "SELECT * FROM daily ORDER BY id LIMIT $offset, 5";
        $result = $this->conn->query($sql);
        $total_seconds = 0;

        if ($result->rowCount() > 0) {
            echo '<form action="" method="post">';
            echo '<table class="table table-striped">';
            echo '<thead class="table-dark"><tr><th>#</th><th>Arrived at</th><th>Leaved at</th><th>Required work off</th><th>Worked off</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $worked_off_class = $row["worked_off"] ? 'class="worked-off"' : '';
                echo "<tr $worked_off_class>";
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["arrived_at"] . '</td>';
                echo '<td>' . $row["leaved_at"] . '</td>';

                if ($row["required_work"] < 3600){
                    echo '<td>' . $row["required_work"] / 60 . " min" . '</td>';
                } else {
                    echo '<td>' . (int)($row["required_work"] / 3600) . " hours " . (int)(($row["required_work"] % 3600) / 60) . " min" . '</td>';
                }
                echo '<td><button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal" data-id="' . $row["id"] . '">Done</button></td>';
                echo '</tr>';

                if ($row["worked_off"] == 0) {
                    $total_seconds += (int)$row['required_work'];
                }
            }
            
            echo '<tr><td colspan="4" class="text-end fw-bold">Total work off hours</td><td>' . $total_seconds . ' seconds' . ' min.</td></tr>';
            echo '</tbody>';
            echo '</table>';
            echo '<button type="submit" name="export" class="btn btn-primary">Export as CSV</button>';
            echo '</form>';
        }
    }

    public function updateWorkedOff($id) {
        $sql = "UPDATE daily SET worked_off = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function exportCSV() {
        $sql = "SELECT * FROM daily";
        $result = $this->conn->query($sql);

        $filename = "work_off_report_" . date('Ymd') . ".csv";
        $file = fopen('php://output', 'w');

        $header = array("ID", "Arrived At", "Leaved At", "Required Work Off", "Worked Off");
        fputcsv($file, $header);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($file, $row);
        }

        fclose($file);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        exit();
    }

    public function getTotalPages($records_per_page) {
        $sql = "SELECT COUNT(*) as total FROM daily";
        $result = $this->conn->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return ceil($row['total'] / $records_per_page);
    }
}

?>