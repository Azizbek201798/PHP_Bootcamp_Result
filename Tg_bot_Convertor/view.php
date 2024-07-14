<?php

declare(strict_types=1);

require 'SaveUsersData.php';

$allusers = new SaveUsersData();
$usersInfo = $allusers->sendAllUsersInfo();

print_r($usersInfo, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter Bot</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Chat ID</th>
            <th scope="col">Conversion Type</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usersInfo as $userInfo): ?>
            <tr>
                <th scope="row"><?php
                    echo $userInfo['id']; ?></th>
                <td><?php
                    echo $userInfo['user_chat_id']; ?></td>
                <td><?php
                    echo $userInfo['user_convertion_type']; ?></td>
                <td><?php
                    echo $userInfo['user_amount']; ?></td>
                <td><?php
                    echo $userInfo['user_data_time']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
