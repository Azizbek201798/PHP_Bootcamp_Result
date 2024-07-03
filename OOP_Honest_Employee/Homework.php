<?php

class Workly_by_Sardor_Dushamov{

    public $days;
    
    public function __construct() {
        $this->days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    }
    
    public function Form() {
        echo '<form action="Homework.php" method="post">';
    
        foreach ($this->days as $day) {
            echo "<h3>$day</h3>";
            echo "Date: <input type='date' name='{$day}_Date'><br><br>";
            echo "Arrived_at: <input type='time' name='{$day}_Arrived_at'><br><br>";
            echo "Leaved_at: <input type='time' name='{$day}_Leaved_at'><br><br>";
        }
        
        echo '<button type="submit">Send</button>';
        echo '</form>';
        echo '<pre>';
    }
    
    public function calculateWorkTime() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $totalWorkTime = 0;
            $totalWorkOff = 0;
    
            foreach ($this->days as $day) {

                $dateKey = $day . '_Date';
                $arrivedKey = $day . '_Arrived_at';
                $leavedKey = $day . '_Leaved_at';
    
                if ($_POST[$dateKey] == "") {
                    echo "String tipidagi $day Date kiriting!\n";
                } else {
                    echo "$day Date       : " . $_POST[$dateKey] . "\n";
                }
    
                if ($_POST[$arrivedKey] == "") {
                    echo "String tipidagi $day Arrived_at kiriting!\n";
                } else {
                    echo "$day Arrived_at : " . $_POST[$arrivedKey] . "\n";
                }
    
                if ($_POST[$leavedKey] == "") {
                    echo "String tipidagi $day Leaved_at kiriting!\n";
                } else {
                    echo "$day Leaved_at  : " . $_POST[$leavedKey] . "\n";
                }
    
                $date = $_POST[$dateKey];
    
                $arrivedTime = strtotime($date . ' ' . $_POST[$arrivedKey]);
                $leavedTime = strtotime($date . ' ' . $_POST[$leavedKey]);
    
                $duration = $leavedTime - $arrivedTime;
                $workTime = max($duration, 0);
                $workOff = max(32400 - $duration, 0);
    
                $hours = (int)($workTime / 3600);
                $minutes = (int)(($workTime % 3600) / 60);
                $seconds = $workTime % 60;
    
                $time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    
                echo "$day Work duration : " . $time . "\n\n";
    
                $totalWorkTime += $workTime;
                $totalWorkOff += $workOff;
            }
    
            $totalHours = (int)($totalWorkTime / 3600);
            $totalMinutes = (int)(($totalWorkTime % 3600) / 60);
            $totalSeconds = $totalWorkTime % 60;
    
            $totalTime = sprintf("%02d:%02d:%02d", $totalHours, $totalMinutes, $totalSeconds);
    
            $totalOffHours = (int)($totalWorkOff / 3600);
            $totalOffMinutes = (int)(($totalWorkOff % 3600) / 60);
            $totalOffSeconds = $totalWorkOff % 60;
    
            $totalOffTime = sprintf("%02d:%02d:%02d", $totalOffHours, $totalOffMinutes, $totalOffSeconds);
    
            echo "Total Work Duration: $totalTime\n";
            echo "Total Work Off Time: $totalOffTime\n";
        }
    }
}
 
$calculator = new Workly_by_Sardor_Dushamov();
$calculator->Form();
$calculator->calculateWorkTime();
q


?>
