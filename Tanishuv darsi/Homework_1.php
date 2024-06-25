<?php

echo "Ismingiz : ";
$name = fgets(STDIN);
$name = trim($name);
echo 1;
echo "Familiyangiz : ";
$surname = fgets(STDIN);
$surname = trim($surname);
 
echo "Yoshingiz : ";
$age = fgets(STDIN);
$age = trim($age);

echo "Tug'ulgan yilinigiz : ";
$year = fgets(STDIN);
$year = trim($year);

echo "\nAssalomu aleykum, Mening ismim $name, familiyam $surname.Men $age yoshdaman. Men $year da tavallud topganman!\n";

?>