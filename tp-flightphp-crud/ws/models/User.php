<?php
require_once __DIR__ . '/../db.php';

class User {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM User");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Users: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM User WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching User by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO User (nom, prenom, contact, email, mdp) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, $data->mdp]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating User: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE User SET nom = ?, prenom = ?, contact = ?, email = ?, mdp = ? WHERE id = ?");
            $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, $data->mdp, $id]);
        } catch (PDOException $e) {
            error_log("Error updating User: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM User WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting User: " . $e->getMessage());
        }
    }
}
?>