<?php

require_once __DIR__ . '/../db.php';

class Retour {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Pret_Retour");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Pret_Retour (id_client_pret, montant, date) VALUES (?, ?, ?)");
        $stmt->execute([$data->id_client_pret, $data->montant, $data->date]);
        return $db->lastInsertId();
    }
}