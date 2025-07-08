<?php
require_once __DIR__ . '/../db.php';

class Departement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM departement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM departement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        error_log("INSERT");
        $db = getDB();
        
        // Conversion robuste en booléen
        $autorise = filter_var($data->autorise, FILTER_VALIDATE_BOOLEAN);
        
        $stmt = $db->prepare("INSERT INTO departement (designation, autorise) VALUES (?, ?)");
        
        // Convertir le booléen en entier pour MySQL (1 ou 0)
        $stmt->execute([
            $data->designation, 
            $autorise ? 1 : 0
        ]);
        
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        error_log("UPDATEMODEL");
        error_log($id);
        error_log(json_encode($data));
        $db = getDB();
        
        // Convertir la valeur numérique en boolean
        $autorise = filter_var($data->autorise, FILTER_VALIDATE_BOOLEAN);
        
        $stmt = $db->prepare("UPDATE departement SET designation= ?, autorise=? WHERE id=?");
        
        // Utiliser les bonnes variables (remarquez que j'ai enlevé $data->nom qui n'est pas dans votre requête SQL)
        $stmt->execute([$data->designation, $autorise ? 1 : 0,$id]);

    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM departement WHERE id = ?");
        $stmt->execute([$id]);
    }
}