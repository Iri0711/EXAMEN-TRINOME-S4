<?php
require_once __DIR__ . '/../db.php';

class Departement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM departement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM departement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO departement (nom, description, responsable) VALUES (?, ?, ?)");
        $stmt->execute([$data->nom, $data->description, $data->responsable]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE departement SET nom = ?, description = ?, responsable = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->description, $data->responsable, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM departement WHERE id = ?");
        $stmt->execute([$id]);
    }
}