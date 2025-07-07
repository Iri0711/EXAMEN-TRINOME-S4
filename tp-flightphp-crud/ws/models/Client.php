<?php
require_once __DIR__ . '/../db.php';

class Client {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM Client");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Clients: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM Client WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Client by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Client (id_user) VALUES (?)");
            $stmt->execute([$data->id_user]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating Client: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE Client SET id_user = ? WHERE id = ?");
            $stmt->execute([$data->id_user, $id]);
        } catch (PDOException $e) {
            error_log("Error updating Client: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM Client WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting Client: " . $e->getMessage());
        }
    }
}
?>