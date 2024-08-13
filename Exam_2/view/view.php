<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>

<style>
    <?php require 'view/style.css';?>
</style>

<body>

    <div class="container">
            
            <h1>Telegramga post yuborish</h1>

            <form method="post" action="/">
                <label for="content">Post:</label>
                <textarea id="content" name="text" placeholder="Post matnini kiriting ... "></textarea>
                <button type="submit">Send Post</button>
            </form>
            <br>
    <?php 
        $task = new Task();
        $posts =  $task->getAllTasks()?>
        <?php foreach ($posts as $post):?>            
            <li><?php echo $post['describtion']; ?></li><br>
        <?php endforeach ?>
        
    </div>
    <div>
    </div>

</body>

</html>