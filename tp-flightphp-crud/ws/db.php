<?php
function getDB() {
    try {
        $db = new PDO('mysql:host=localhost;dbname=banque', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        // Log l'erreur pour le débogage
        error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion à la base de données']);
        exit;
    }
}