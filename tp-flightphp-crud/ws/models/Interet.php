<?php
require_once __DIR__ . '/../db.php';

class Interet {
    public static function getAll($data) {
        error_log("Début Interet::getAll()");
        error_log("Paramètres reçus: " . print_r($data, true));

        $db = getDB();
        if (!$db) {
            error_log("Échec connexion DB");
            return ["error" => "Database connection failed"];
        }

        try {
            // Version debug avec requête simple
            $testSql = "SELECT 1+1 AS test";
            $stmt = $db->query($testSql);
            error_log("Test DB: " . print_r($stmt->fetch(), true));

            // Votre requête actuelle
            $sql = "CALL calculInteretMensuel(?, ?)";
            error_log("Exécution de: $sql avec params: $data->debut, $data->fin");
            
            $stmt = $db->prepare($sql);
            $stmt->execute([$data->debut, $data->fin]);
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Résultats bruts: " . print_r($results, true));
            
            return $results;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO: " . $e->getMessage());
            return ["error" => $e->getMessage()];
        }
    }
}

