<?php
require_once __DIR__ . '/db.php';

class Client {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM clients");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching clients: " . $e->getMessage());
            throw new Exception("Error fetching clients: " . $e->getMessage());
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM clients WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching client by ID: " . $e->getMessage());
            throw new Exception("Error fetching client by ID: " . $e->getMessage());
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO clients (id_user) VALUES (?)");
            $stmt->execute([$data->id_user]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating client: " . $e->getMessage());
            throw new Exception("Error creating client: " . $e->getMessage());
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE clients SET id_user = ? WHERE id = ?");
            $stmt->execute([$data->id_user, $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error updating client: " . $e->getMessage());
            throw new Exception("Error updating client: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM clients WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting client: " . $e->getMessage());
            throw new Exception("Error deleting client: " . $e->getMessage());
        }
    }
}
?>