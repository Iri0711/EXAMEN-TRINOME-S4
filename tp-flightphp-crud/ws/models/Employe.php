<?php
require_once __DIR__ . '/../db.php';

class Employe {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM Employe");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Employes: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM Employe WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Employe by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Employe (id_user, id_dept) VALUES (?, ?)");
            $stmt->execute([$data->id_user, $data->id_dept]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating Employe: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE Employe SET id_user = ?, id_dept = ? WHERE id = ?");
            $stmt->execute([$data->id_user, $data->id_dept, $id]);
        } catch (PDOException $e) {
            error_log("Error updating Employe: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM Employe WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting Employe: " . $e->getMessage());
        }
    }
}
?>