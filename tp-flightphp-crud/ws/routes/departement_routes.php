<?php
require_once __DIR__ . '/../controllers/DepartementController.php';

// Définition des routes pour les opérations sur les départements
Flight::route('GET /api/departements', ['DepartementController', 'getAll']); // Liste tous les départements
Flight::route('GET /api/departements/@id', ['DepartementController', 'getById']); // Récupère un département par ID
Flight::route('POST /api/departements', ['DepartementController', 'create']); // Crée un nouveau département
Flight::route('PUT /api/departements/@id', ['DepartementController', 'update']); // Met à jour un département
Flight::route('DELETE /api/departements/@id', ['DepartementController', 'delete']); // Supprime un département

// Serve HTML page
Flight::route('GET /departements', function() {
    echo file_get_contents(__DIR__ . '/../../public/departements.html');
});
?>