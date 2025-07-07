<?php
require_once __DIR__ . '/../db.php';

class Departement {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM Departement");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Departements: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM Departement WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Departement by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Departement (designation, autorise) VALUES (?, ?)");
            $stmt->execute([$data->designation, $data->autorise]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating Departement: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE Departement SET designation = ?, autorise = ? WHERE id = ?");
            $stmt->execute([$data->designation, $data->autorise, $id]);
        } catch (PDOException $e) {
            error_log("Error updating Departement: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM Departement WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting Departement: " . $e->getMessage());
        }
    }
}
?>