<?php    

    require 'vendor/autoload.php';

    use GuzzleHttp\Client;

    $update = json_decode(file_get_contents('php://input'));

    if(isset($update)){
        require 'bot/bot.php';
        return;
    }

    require 'src/DB.php';
    require 'src/Todo.php';    

    $todo = new Todo();
    
    if (!empty($_POST)){
        if (strlen($_POST['text'])){
            $todo->addTodo($_POST['text']);
            header('Location: index.php');
        }
    }

    if (!empty($_GET)){
        if (isset($_GET['update'])){
            $todo->updateStatus($_GET['update']);
        }

        if (isset($_GET['delete'])){
            $todo->deleteTodo($_GET['delete']);
        }
        require 'view/view.php';

    }
