<?php
require_once 'config/database.php';
require_once 'models/Task.php';

$id = $_POST['id'];
$status = $_POST['status'];

if ($id && in_array($status, ['todo', 'doing', 'done'])) {
    $task = new Task($pdo);
    $task->updateStatus($id, $status);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}