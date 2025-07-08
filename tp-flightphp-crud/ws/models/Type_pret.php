<?php
require_once __DIR__ . '/../db.php';

class Type_pret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Pret_Type");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Pret_Type WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Pret_Type (libelle, taux, duree) VALUES (?, ?, ?)");
        $stmt->execute([$data->libelle, $data->taux, $data->duree]);
        return $db->lastInsertId();
    }

    // public static function update($id, $data) {
    //     $db = getDB();
    //     $stmt = $db->prepare("UPDATE Pret_Type SET etudiant_id = ?, materiel = ?, date_pret = ?, date_retour = ? WHERE id = ?");
    //     $stmt->execute([$data->etudiant_id, $data->materiel, $data->date_pret, $data->date_retour, $id]);
    // }
    // public static function delete($id) {
    //     $db = getDB();
    //     $stmt = $db->prepare("DELETE FROM Pret_Type WHERE id = ?");
    //     $stmt->execute([$id]);
    // }
}