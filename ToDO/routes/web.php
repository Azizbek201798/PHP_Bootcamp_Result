<?php

declare(strict_types=1);

$task = new Todo($db);

if (count($_GET) > 0 || count($_POST) > 0) {
    if (isset($_POST['text'])) {
        $task->addTodo($_POST['text']);
    }

    if (isset($_GET['complete'])) {
        $task->changeStatus($_GET['complete']);
    }

    if (isset($_GET['uncompleted'])) {
        $task->changeStatus($_GET['uncompleted']);
    }

    if (isset($_GET['delete'])) {
        $task->deleteTodo($_GET['delete']);
    }
}