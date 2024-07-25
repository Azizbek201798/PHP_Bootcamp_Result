<?php

class Todo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkId($id){
        $stmt = $this->pdo->prepare('SELECT id FROM todos WHERE id = ?;');
        $stmt->execute([$id]);
        var_dump(count($stmt->fetchAll()));
        return count($stmt->fetchAll());
    }

    public function getTodos()
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM todos;');
            var_dump($stmt->fetchAll());
        } catch (\Throwable $th) {
            echo $th->getMessage();
            print_r($th->getTrace());
            print_r($th->getLine());
        }
    }

    public function addTodo($title)
    {
        $stmt = $this->pdo->prepare('INSERT INTO todos (title) VALUES (?)');
        $stmt->execute([$title]);
    }

    public function changeStatus($id)
    {
        $id = (int)$id;
        $stmt = $this->pdo->prepare('SELECT completed FROM todos WHERE id = ?');
        $stmt->execute([$id]);
        $todo = $stmt->fetch();
        $newStatus = $todo['completed'] ? 0 : 1;
        $stmt = $this->pdo->prepare('UPDATE todos SET completed = ? WHERE id = ?');
        $stmt->execute([$newStatus, $id]);
    }

    public function deleteTodo($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM todos WHERE id = ?');
        $stmt->execute([$id]);
    }
}