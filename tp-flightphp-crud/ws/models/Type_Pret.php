<?php
require_once __DIR__ . '/../db.php';

class Type_Pret {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM Pret_Type");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Pret Types: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM Pret_Type WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Pret Type by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Pret_Type (libelle, taux, duree) VALUES (?, ?, ?)");
            $stmt->execute([$data->libelle, $data->taux, $data->duree]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating Pret Type: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE Pret_Type SET libelle = ?, taux = ?, duree = ? WHERE id = ?");
            $stmt->execute([$data->libelle, $data->taux, $data->duree, $id]);
        } catch (PDOException $e) {
            error_log("Error updating Pret Type: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM Pret_Type WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting Pret Type: " . $e->getMessage());
        }
    }
}
?>