<?php
require_once __DIR__ . '/../db.php';

class Employe {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Employe");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Employe WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Employe (id_user, id_dept) VALUES (?, ?)");
        $stmt->execute([$data->id_user, $data->id_dept]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Employe SET id_user = ?, id_dept = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $data->id_dept, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Employe WHERE id = ?");
        $stmt->execute([$id]);
    }
}