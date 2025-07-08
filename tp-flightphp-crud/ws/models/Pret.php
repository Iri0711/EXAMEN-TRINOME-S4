<?php

require_once __DIR__ . '/../helpers/Utils.php';

class Pret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT pc.id as pid ,c.id as cid, pc.id_pret_type , pc.montant , pc.date FROM Pret_Client pc join Client c on pc.id_client=c.id WHERE pc.montant > 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Pret_Client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Pret_Client (id_client,id_etab, id_pret_type, montant, date) VALUES (?, 1,?, ?, ?)");
        $stmt->execute([$data->id_client, $data->id_pret_type, $data->montant, date('Y-m-d H:i:s')]);
        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'message' => 'Prêt ajouté',
                'id' => $db->lastInsertId()
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Erreur lors de l\'ajout du prêt'
            ];
        }
    }
}