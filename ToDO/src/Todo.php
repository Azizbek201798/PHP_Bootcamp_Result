<?php

class Todo extends DB
{

    public function getTodos()
    {
        $stmt = $this->pdo->query('SELECT * FROM todos');
        return $stmt->fetchAll();
    }

    public function addTodo(string $title)
    {
        $status = false;
        $stmt = $this->pdo->prepare('INSERT INTO todos (title,status) VALUES (:title,:completed)');
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':status',$status,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateStatus($id)
    {
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
