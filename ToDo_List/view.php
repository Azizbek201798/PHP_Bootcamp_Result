<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <ul>
    <?php   
        $todoList = $todo->getToDo();
        foreach($todoList as $item):
               echo "<li>{$item['text']}</li>";
        endforeach; 
    ?>
    </ul>

    <form action="" method="post">
        <input type="checkbox">
        <input type="text" name="text">
        <button type="submit">Add</button>
        <button type="submit">Update</button>
        <button type="submit">Delete</button>
    </form>

</body>
</html>