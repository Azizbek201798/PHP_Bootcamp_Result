<?php
    require 'DB.php';
    require 'Club.php';

    $database = DB::connect();
    $club = new Club($database);
    $info = $club->getAll();

    if(!empty($_POST['ism']) && !empty($_POST['familiya']) && !empty($_POST['jamoa']) && !empty($_POST['mamlakat'])){
        $club->addItem($_POST['ism'],$_POST['familiya'],$_POST['jamoa'],$_POST['mamlakat']);
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        <?php require 'view/style.css';?>
    </style>
    <title>Barselona</title>
</head>

<body>
    
    <h1></h1>

    <form action="index.php" method="POST">
        <label for="1">Futbolchi ismini kiriting : </label>
        <input type="text" name="ism" required id="1"><br>
        <label for="2">Futbolchi familiyasini kiriting : </label>
        <input type="text" name="familiya" required id="2"><br>
        <label for="3">Futbolchining jamoasini : </label>
        <input type="text" name="jamoa" required id="3"><br>
        <label for="4">Futbolchi mamlakatini : </label>
        <input type="text" name="mamlakat" required id="4"><br>

        <input class="btn btn-primary" type="submit" value="Submit">
    </form>

    <?php
    require 'view/table.php';
    ?>


</body>
</html>