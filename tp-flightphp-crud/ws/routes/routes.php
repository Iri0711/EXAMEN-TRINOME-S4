<?php
require 'flight/Flight.php';
require_once 'client_routes.php';
require_once 'departement_routes.php';
require_once 'employe_routes.php';
require_once 'etablissement_routes.php';
require_once 'type_pret_routes.php';
require_once 'user_routes.php';
require_once 'pret_retour_routes.php'; // Add this for interests

// Serve static HTML pages
Flight::route('GET /', function(){
    Flight::render('index.html');
});

Flight::route('GET /clients', function(){
    Flight::render('clients.html');
});

Flight::route('GET /departements', function(){
    Flight::render('departements.html');
});

Flight::route('GET /etablissements', function(){
    Flight::render('etablissements.html');
});

Flight::route('GET /employes', function(){
    Flight::render('employees.html');
});

Flight::route('GET /prets', function(){
    Flight::render('prets.html');
});

Flight::route('GET /users', function(){
    Flight::render('users.html');
});

Flight::route('GET /interets', function(){
    Flight::render('interets.html');
});

Flight::start();
?>