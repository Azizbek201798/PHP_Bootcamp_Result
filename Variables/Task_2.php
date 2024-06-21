<?php

echo "Isminigiz : ";
$Ism = fgets(STDIN);
$Ism = trim($Ism);

echo "Tug'ulgan yilingiz : ";
$year = fgets(STDIN);
define("Year",$year); 

$age = 2024 - Year;

echo "\nAssalomu aleykum, hurmatli $Ism! Siz $age yoshdasiz!\n";

?>
