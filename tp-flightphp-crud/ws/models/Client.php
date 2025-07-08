<?php
require_once __DIR__ . '/../db.php';

class Client {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT c.id as cid ,u.id as uid, u.nom, u.prenom, u.email FROM Client c join User u on c.id_user = u.id");
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
        $stmt = $db->prepare("INSERT INTO Client (nom, prenom, email) VALUES (?, ?, ?)");
        $stmt->execute([$data->nom, $data->prenom, $data->email]);
        return $db->lastInsertId();
    }
}