<?php
class Task {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByStatus($status) {
        $stmt = $this->db->prepare("SELECT * FROM TODOLIST WHERE STATUS = ?");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($title, $desc, $tag) {
        $stmt = $this->db->prepare("INSERT INTO TODOLIST (TITLE, DESCRIPTION, STATUS, TAG) VALUES (?, ?, 'todo', ?)");
        return $stmt->execute([$title, $desc, $tag]);
    }

    public function update($id, $title, $desc, $tag) {
        $stmt = $this->db->prepare("UPDATE TODOLIST SET TITLE = ?, DESCRIPTION = ?, TAG = ? WHERE ID = ?");
        return $stmt->execute([$title, $desc, $tag, $id]);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE TODOLIST SET STATUS = ? WHERE ID = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM TODOLIST WHERE ID = ?");
        return $stmt->execute([$id]);
    }

    public function toggleImportant($id, $important) {
        $stmt = $this->db->prepare("UPDATE TODOLIST SET IMPORTANT = ? WHERE ID = ?");
        return $stmt->execute([$important, $id]);
    }   
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM TODOLIST WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
