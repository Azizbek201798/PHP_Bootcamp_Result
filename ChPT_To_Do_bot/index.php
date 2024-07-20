<?php

// Set up your Telegram bot token
$botToken = '7411716108:AAHie4mj97bbY6VWcUppRULe_aCOI7fCysY';

// Get the incoming message
$update = json_decode(file_get_contents('php://input'), true);

// Get the chat ID and the message text
$chatID = $update['message']['chat']['id'];
$messageText = $update['message']['text'];

// Process the incoming message
switch ($messageText) {
    case '/start':
        sendMessage($chatID, 'Welcome to the Todo Bot! Use /addtask to add a new task.');
        break;
    case '/addtask':
        $taskText = substr($messageText, 9); // Remove '/addtask ' from the message
        addTask($chatID, $taskText);
        break;
    case '/viewtasks':
        viewTasks($chatID);
        break;
    case '/checktask':
        $taskIndex = substr($messageText, 11); // Remove '/checktask ' from the message
        checkTask($chatID, $taskIndex);
        break;
    default:
        sendMessage($chatID, 'Invalid command.');
        break;
}

// Send a message
function sendMessage($chatID, $message) {
    $url = 'https://api.telegram.org/bot' . $GLOBALS['botToken'] . '/sendMessage';
    $data = array(
        'chat_id' => $chatID,
        'text' => $message
    );
    file_get_contents($url . '?' . http_build_query($data));
}

// Add a new task to the list
function addTask($chatID, $taskText) {
    // Implement your task storage and retrieval logic here
    // For simplicity, we'll use a text file to store the tasks
    $file = 'tasks.txt';
    $task = ['text' => $taskText, 'checked' => false];
    file_put_contents($file, json_encode($task) . PHP_EOL, FILE_APPEND);
    sendMessage($chatID, 'Task added successfully!');
}

// View all tasks
function viewTasks($chatID) {
    // Implement your task storage and retrieval logic here
    // For simplicity, we'll use a text file to store the tasks
    $file = 'tasks.txt';
    if (file_exists($file)) {
        $tasks = file($file, FILE_IGNORE_NEW_LINES);
        if (count($tasks) > 0) {
            $taskList = '';
            foreach ($tasks as $index => $task) {
                $taskObj = json_decode($task, true);
                $taskList .= ($taskObj['checked'] ? '✓ ' : '✗ ') . $taskObj['text'] . PHP_EOL;
            }
            sendMessage($chatID, 'Tasks:' . PHP_EOL . $taskList);
        } else {
            sendMessage($chatID, 'No tasks found.');
        }
    } else {
        sendMessage($chatID, 'No tasks found.');
    }
}

// Check/uncheck a task
function checkTask($chatID, $taskIndex) {
    // Implement your task storage and retrieval logic here
    // For simplicity, we'll use a text file to store the tasks
    $file = 'tasks.txt';
    if (file_exists($file)) {
        $tasks = file($file, FILE_IGNORE_NEW_LINES);
        if ($taskIndex >= 0 && $taskIndex < count($tasks)) {
            $taskObj = json_decode($tasks[$taskIndex], true);
            $taskObj['checked'] = !$taskObj['checked'];
            $tasks[$taskIndex] = json_encode($taskObj);
            file_put_contents($file, implode(PHP_EOL, $tasks));
            sendMessage($chatID, 'Task updated successfully!');
        } else {
            sendMessage($chatID, 'Invalid task index.');
        }
    } else {
        sendMessage($chatID, 'No tasks found.');
    }
}