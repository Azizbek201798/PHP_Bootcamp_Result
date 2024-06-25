<?php

declare(strict_types = 1);

// Userni kiritilgan sanada qancha vaqt ishlaganligini aniqlovchi funksiya(Format 08:30:00 AM or PM);
function Calculate_Hours(string $Date,string $Arrived_at,string $Leaved_at) : string{

    $arrivedTime = strtotime($Date . ' ' . $Arrived_at);
    $leavedTime = strtotime($Date . ' ' . $Leaved_at);
    
    $duration = $leavedTime - $arrivedTime;

    $hours = (int)($duration / 3600);
    $minutes = (int)(($duration % 3600) / 60);
    $seconds = $duration % 60;

    $time = sprintf("%02d:%02d:%02d",$hours,$minutes,$seconds);  

    return  "\nDate : " . $Date . "Arrived_at : " . $Arrived_at . "Leaved_at : " . $Leaved_at . "Work Duration : " . $time . PHP_EOL;    

}

// User kelgan sana,kelish_vaqti va ketish_vaqtini kiritadi;
echo "Sanani kiriting                    : ";
$Date = fgets(STDIN);
echo "Ishga kelgan vatingizni kiriting   : ";
$Arrived_at = fgets(STDIN);
echo "Ishdan ketgan vaqtingizni kiriting : ";
$Leaved_at = fgets(STDIN);

echo Calculate_Hours($Date,$Arrived_at,$Leaved_at);

?>