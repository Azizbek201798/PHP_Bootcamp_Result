<?php 
class User extends DB{
    public function save_user($chat_id){      
        $check = $this->pdo->query('SELECT * FROM users WHERE user_id={$chat_id}')->fetch();      
        if(!$check){              
            $user = $this->pdo->prepare('INSERT INTO users (user_id) VALUES (:chat_id);');
            $user->bindParam(':chat_id',$chat_id);
            $user->execute();
        }
    }
}