<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
</head>
<body>

    <ul>
    <?php   
        $todoList = $todo->getToDo();
        foreach($todoList as $item):
               echo "{$item['id']}) {$item['name']}<br>";
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