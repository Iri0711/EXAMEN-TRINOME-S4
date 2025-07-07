<?php
require_once __DIR__ . '/../db.php';

class Etablissement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM etablissement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM etablissement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO etablissement (nom, adresse, ville, code_postal) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->adresse, $data->ville, $data->code_postal]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE etablissement SET nom = ?, adresse = ?, ville = ?, code_postal = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->adresse, $data->ville, $data->code_postal, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM etablissement WHERE id = ?");
        $stmt->execute([$id]);
    }
}