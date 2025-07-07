<?php
require_once __DIR__ . '/../db.php';

class Type_Pret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM pret_type");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret_type WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO pret_type (libelle, taux, duree) VALUES (?, ?, ?)");
        $stmt->execute([$data->libelle, $data->taux, $data->duree]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE pret_type SET libelle = ?, taux = ?, duree = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->taux, $data->duree, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM pret_type WHERE id = ?");
        $stmt->execute([$id]);
    }
}