
    <ul>
        <?php
             $todoList = $todo->getToDo();
             var_dump($todoList);
             foreach($todoList as $item):
                echo "<li>{$item['text']}</li>";
             endforeach;
        ?>
    </ul>

    <form action="index.php" method="post">
        <input type="checkbox">
        <input type="text" name="text">
        <button type="submit">Add</button>
    </form>
