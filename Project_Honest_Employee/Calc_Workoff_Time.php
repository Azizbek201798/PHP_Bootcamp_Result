<form action="Calc_Workoff_Time.php" method = "post">

    Date <input type="date" name = "Date"> <br><br>
    Arrived_at <input type="time" name = "Arrived_at"> <br><br>
    Leaved_at <input type="time" name = "Leaved_at"><br><br>
    <button>Send</button>

</form>

<pre>
<?php

if ($_POST['Date'] == ""){
    echo "String tipidagi Date kiriting!\n";
} else{
    echo "Date       : " . $_POST['Date'] . "\n";
}

if ($_POST['Arrived_at'] == ""){
    echo "String tipidagi Arived_at kiriting!\n";
}else{
    echo "Arrived_at : " . $_POST['Arrived_at'] . "\n";
}

if ($_POST['Leaved_at'] == ""){
    echo "String tipidagi Leaved_at kiriting!\n";
}else{
    echo "Leaved_at  : " . $_POST['Leaved_at'] . "\n";
}

$arrivedTime = strtotime($Date . ' ' . $_POST['Arrived_at']);
$leavedTime = strtotime($Date . ' ' . $_POST['Leaved_at']);

$duration   = $leavedTime - $arrivedTime;

$hours = (int)($duration / 3600);
$minutes = (int)(($duration % 3600) / 60);
$seconds = $duration % 60;

$time = sprintf("%02d:%02d:%02d",$hours,$minutes,$seconds); 

echo "\nWork duration : " . $time . "\n";

$total_work_of = 0;

// Umumiy ishlash vaqti 9 soat ya'ni 32400 sekund agar ishlagan vaqti undan kam bo'lsa ishlab beradi;
if ($duration < 32400){
    $total_work_of += (32400 - $duration);
    $hours = (int)($total_work_of / 3600);
    $minutes = (int)(($total_work_of % 3600) / 60);
    $seconds = $total_work_of % 60;
    $time = sprintf("%02d:%02d:%02d",$hours,$minutes,$seconds); 

    echo "Debted time   : $time\n";
} else {
    echo "Ishlab berishingiz shart emas!\n"; 
}

?>
</pre>