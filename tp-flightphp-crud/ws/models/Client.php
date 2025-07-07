<?php
require_once __DIR__ . '/../db.php';

class Client {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Client (id_user) VALUES (?)");
        $stmt->execute([$data->id_user]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Client SET id_user = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Client WHERE id = ?");
        $stmt->execute([$id]);
    }
}