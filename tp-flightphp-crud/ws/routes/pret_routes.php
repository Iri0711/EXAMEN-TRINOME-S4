<?php
require_once __DIR__ . '/../controllers/PretController.php';

Flight::route('GET /prets', ['PretController', 'getAllTypesPret']);
Flight::route('GET /allPret', ['PretController', 'getAllPrets']);
Flight::route('GET /retours', ['PretController', 'getAllRetours']);

Flight::route('POST /create_pret', ['PretController', 'createPret']);
Flight::route('POST /type_pret', ['PretController', 'createTypePret']);
Flight::route('POST /retourPret', ['PretController', 'createRetour']);

Flight::route('GET /pretClient/remainingBalances', ['PretController', 'getRemainingBalances']);