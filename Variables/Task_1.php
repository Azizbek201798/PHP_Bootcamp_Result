<?php

echo "Ismingiz : ";
$Ism = fgets(STDIN);
$Ism = trim($Ism);

echo "Sharifingiz : ";
$Sharif = fgets(STDIN);
$Sharif = trim($Sharif);

echo "Yoshingiz : ";
$Yosh = fgets(STDIN);
$Yosh = trim($Yosh);

echo "Telefon raqamingiz : ";
$Raqam = fgets(STDIN);
$Raqam = trim($Raqam);

echo "Pochta manzilingiz : ";
$Email = fgets(STDIN);
$Email = trim($Email);

echo "Yashash manzilingiz : ";
$Manzil = fgets(STDIN);
$Manzil = trim($Manzil);

echo "Oldin foundation kursini o'qiganmizsiz(Ha/Yo'q) : ";
$Foundation = fgets(STDIN);
$Foundation = trim($Foundation);

echo "\nARIZA QABUL QILINDI!:\n\nIsmi : $Ism\nOtasining ismi : $Sharif\nYoshi : $Yosh\nTelefon raqami : $Raqam\nEmail : $Email\nManzil : $Manzil\nFoundationda o'qiganmi : $Foundation\n";

?>