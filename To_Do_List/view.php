<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c4497f215d.js" crossorigin="anonymous"></script>
    <title>To Do List</title>
</head>

<body>

    <?php 
        $info = new Task();
        $toDoList = $info->getAll();

        foreach($toDoList as $item){
            echo $item;
        }
    ?>

    <h1>To Do List</h1>
    
    <form action="" name="todoList">
        <input type="checkbox" name="option1" id="1">
        <input type="text" >
        <input type="submit" value="Add">
    </form>

</body>

</html>