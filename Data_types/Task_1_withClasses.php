<?php

class Matn{
    public $limit;
    public $matn;

    public function __construct($limit,$matn)
    {
        $this->limit = $limit;    
        $this->matn = $matn;

    }

    public function Matn_Uzunligi($matn){
        return strlen($matn);
    }

    public function Qolgan_Belgilar_Soni($limit,$matn){
        return $limit - strlen($matn);
    }

}

$limit = 100;
echo "$limit ta belgidan iborat bo'lgan matnni kiriting : ";
$text = trim(fgets(STDIN));

// Obyekt yaratilishi oldidan matn uzunligini tekshirish; 
if (strlen($text) > $limit){
    echo "Kiritilgan matnda belgilar soni $limit dan oshib keldi!\n";
    exit();
}

// Yuqoridagi class dan obyekt olish;
$matn = new Matn($limit,$text);

echo "Matn uzunligi : " . $matn->Matn_Uzunligi($text) . "ga teng\nQolgan belgilar soni : " . $matn->Qolgan_Belgilar_Soni($limit,$text) . "ta\n";

?>