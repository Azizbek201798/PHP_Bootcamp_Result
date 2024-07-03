<form action="Monday_to_Friday.php" method="post">
    
    <?php

    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    
    foreach ($days as $day) {

        echo "<h3>$day</h3>";
        echo "Date: <input type='date' name='{$day}_Date'><br><br>";
        echo "Arrived_at: <input type='time' name='{$day}_Arrived_at'><br><br>";
        echo "Leaved_at: <input type='time' name='{$day}_Leaved_at'><br><br>";
    
    }
    
    ?>

    <button type="submit">Send</button>

</form>
<pre>

<?php

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $total_work_time = 0;
    $total_work_off = 0;

    foreach ($days as $day) {
        
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
        $work_time = max($duration, 0);
        $work_off = max(32400 - $duration, 0);

        $hours = (int)($work_time / 3600);
        $minutes = (int)(($work_time % 3600) / 60);
        $seconds = $work_time % 60;

        $time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        echo "$day Work duration : " . $time . "\n\n";

        $total_work_time += $work_time;
        $total_work_off += $work_off;
    }

    $total_hours = (int)($total_work_time / 3600);
    $total_minutes = (int)(($total_work_time % 3600) / 60);
    $total_seconds = $total_work_time % 60;

    $total_time = sprintf("%02d:%02d:%02d", $total_hours, $total_minutes, $total_seconds);

    $total_off_hours = (int)($total_work_off / 3600);
    $total_off_minutes = (int)(($total_work_off % 3600) / 60);
    $total_off_seconds = $total_work_off % 60;

    $total_off_time = sprintf("%02d:%02d:%02d", $total_off_hours, $total_off_minutes, $total_off_seconds);

    echo "Total Work Duration: $total_time\n";
    echo "Total Work Off Time: $total_off_time\n";

}

?>

</pre>