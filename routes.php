<?php
require_once 'config/database.php';
require_once 'controllers/TaskController.php';

$controller = new TaskController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['update'])) {
    $controller->update($_GET['update'], $_POST['title'], $_POST['description'], $_POST['tag']);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['important'])) {
    $controller->toggleImportant($_GET['important'], $_POST['important']);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->insert($_POST['title'], $_POST['description'], $_POST['tag']);
} else if (isset($_GET['delete'])) {
    $controller->delete($_GET['delete']);
} else {
    $controller->index();
}