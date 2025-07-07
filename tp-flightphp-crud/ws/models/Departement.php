<?php
require_once __DIR__ . '/../db.php';

class Departement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Departement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Departement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Departement (designation, autorise) VALUES (?, ?)");
        $stmt->execute([$data->designation, $data->autorise]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Departement SET designation = ?, autorise = ? WHERE id = ?");
        $stmt->execute([$data->designation, $data->autorise, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Departement WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>