<?php

declare(strict_types = 1);

define("Start","9:00:00 AM");
define("End","6:00:00 PM");

// Userni kiritilgan sanada qancha kam yoki ko'p ishlaganligini aniqlovchi funksiya(Format 08:30:00 AM or PM);
function Calculate_Hours(string $Date,string $Arrived_at,string $Leaved_at) : int{

    $total_work_of = 0;

    $arrivedTime = strtotime($Date . ' ' . $Arrived_at);
    $leavedTime = strtotime($Date . ' ' . $Leaved_at);
    
    $duration = $leavedTime - $arrivedTime;

    // Umumiy ishlash vaqti 9 soat ya'ni 32400 sekund agar ishlagan vaqti undan kam bo'lsa ishlab beradi;
    if ($duration < 32400){
        $total_work_of += (32400 - $duration);
    } else {
        $total_work_of -= ($duration - 32400); 
    }

    return $total_work_of;

}

$dates = [];
$total_work_of = 0;

//Foydalanuvchi hohlaganicha sana kiritishi uchun loop ishlatildi; 
//Qadamlar soni no'malum bo'lganligi sababli while ishlatildi;
$op = 1;
while ($op){
    if ($op != 1){
        break;
    } else {
        echo "Sanani kiriting                    : ";
        $Date = fgets(STDIN);
        echo "Ishga kelgan vatingizni kiriting   : ";
        $Arrived_at = fgets(STDIN);
        echo "Ishdan ketgan vaqtingizni kiriting : ";
        $Leaved_at = fgets(STDIN);

        $result = Calculate_Hours($Date,$Arrived_at,$Leaved_at);
        array_push($dates,$result);
        echo "Yana sana kiritishni hohlaysizmi ? 1-Ha;2-Yo'q =>";
    }
    $op = fgets(STDIN);  
}

// Massivga yig'ilgan vaqtlardan umumiy qancha vaqt ishlab berishi kerak bo'lganligini aniqlash;
if (array_sum($dates) < 0){
    echo "Ishlab berishingiz shart emas! Qarzingiz yo'q!\n";
} else {
    $minutes = (int)(array_sum($dates) / 60);
    $seconds = array_sum($dates);

    echo "\nTotal work of =>\nIn Minutes : $minutes;\nIn seconds : $seconds\n";
}

?>