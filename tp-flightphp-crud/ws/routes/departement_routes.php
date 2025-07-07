<?php
require_once __DIR__ . '/../controllers/DepartementController.php';

// Définition des routes pour les opérations sur les départements
Flight::route('GET /departements', ['DepartementController', 'getAll']); // Liste tous les départements
Flight::route('GET /departements/@id', ['DepartementController', 'getById']); // Récupère un département par ID
Flight::route('POST /departements', ['DepartementController', 'create']); // Crée un nouveau département
Flight::route('PUT /departements/@id', ['DepartementController', 'update']); // Met à jour un département
Flight::route('DELETE /departements/@id' , ['DepartementController', 'delete']); // Supprime un département

?>