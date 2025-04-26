<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $task;

    public function __construct($db) {
        $this->task = new Task($db);
    }

    public function index() {
        $tasks = [
            'todo' => $this->task->getByStatus('todo'),
            'doing' => $this->task->getByStatus('doing'),
            'done' => $this->task->getByStatus('done')
        ];
        include __DIR__ . '/../views/taskList.php';
    }

    public function insert($title, $desc, $tag) {
        $this->task->insert($title, $desc, $tag);
        header("Location: /");
    }

    public function update($id, $title, $desc, $tag) {
        $this->task->update($id, $title, $desc, $tag);
        header("Location: /");
    }

    public function delete($id) {
        $this->task->delete($id);
        header("Location: /");
    }
    public function toggleImportant($id) {
        $task = $this->task->getById($id);
        $newImportant = $task['IMPORTANT'] ? 0 : 1;
        $this->task->toggleImportant($id, $newImportant);
        header("Location: /");
    }
    

}