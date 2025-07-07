<?php
require 'flight/Flight.php';
require_once 'etablissement_routes.php';
require_once 'departement_routes.php';
require_once 'type_pret_routes.php';

// Serve static HTML pages
Flight::route('GET /', function(){
    Flight::render('index.html');
});

Flight::route('GET /departements', function(){
    Flight::render('departements.html');
});

Flight::route('GET /etablissements', function(){
    Flight::render('etablissements.html');
});

Flight::route('GET /prets', function(){
    Flight::render('prets.html');
});

Flight::start();