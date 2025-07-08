<?php
require_once __DIR__ . '/../db.php';

class FondValidation{
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT f.id, f.id_etab_fond,ef.montant, f.statut, f.date FROM fond_validation f join etablissement_fond ef on f.id_etab_fond = ef.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM fond_validation WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO fond_validation (id_etab_fond, statut, date) VALUES (?, FALSE, ?)");
        $stmt->execute([$data->id_etab_fond, date('Y-m-d H:i:s')]);
        return $db->lastInsertId();
    }
}