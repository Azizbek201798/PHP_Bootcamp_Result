<?php

    require 'DB.php';
    require 'Todo.php';
    $database = DB::connect();
    $todo = new Todo($database);
    $todos = $todo->getTodos();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>To-do List</title>
    <style>
        <?php require 'style.css'; ?>
    </style>
</head>

<body>

<div class="container">
    <h1 class="mt-5">To-do List</h1>
    <form action="add.php" method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="title" class="form-control" placeholder="Matn kiriting" required>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Qo'shish</button>
            </div>
        </div>
    </form>
    <ul class="list-group">
        <?php foreach ($todos as $todo): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <form action="update.php" method="POST" class="mr-3">
                    <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                    <input type="checkbox"
                           onChange="this.form.submit()" <?php if ($todo['completed']) echo 'checked'; ?>>
                </form>
                <span class="<?php echo $todo['completed'] ? 'completed' : ''; ?>">
                    <?php echo htmlspecialchars($todo['title']); ?>
                </span>
                <a href="delete.php?id=<?php echo $todo['id']; ?>" class="btn btn-danger btn-sm">O'chirish</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>

</html>
