<?php
require_once __DIR__ . '/../db.php';

class User {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO user (nom, prenom, contact, email,mdp) VALUES (?, ?, ?, ?,?)");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email,$data->mdp]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE user SET nom=?, prenom=?, contact=?, email=?,mdp=? WHERE id = ?");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email,$data->mdp, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$id]);
    }
}