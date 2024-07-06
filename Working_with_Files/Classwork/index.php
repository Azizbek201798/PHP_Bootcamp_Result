<?php

    $directory = '/home/azizbek/Desktop/Azizbek_BootCamp/Azizbek_PHP_Result/Git_Commands/';
    chdir($directory);
    
    $file = fopen("Example.txt", 'w+');

    $data = fwrite($file, "Azizbek");
    
    fseek($file, 0);
    
    echo fread($file, 10) . PHP_EOL;
    
    fclose($file);

?>
