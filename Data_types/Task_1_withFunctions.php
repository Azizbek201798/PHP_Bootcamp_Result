<?php

function Matn(){
    
    $limit_max = 100;

    echo "$limit_max ta belgidan iborat bo'lgan matnni kiriting : "; 
    $matn = trim(fgets(STDIN));

    if (strlen($matn) > $limit_max) {

        echo "Matndagi elementlar soni 100 tadan oshib ketdi!\n";
        return;

    } else{

        echo "Kiritilgan matn uzunligi : " . strlen($matn) . "ga teng\nQolgan belgilar soni : " . ($limit_max - strlen($matn)) . "ta\n";

    }

}

// Matn kirituvchi funksiyani chaqirish;
Matn();

?>