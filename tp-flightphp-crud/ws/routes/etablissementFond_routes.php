<?php

require_once __DIR__ . '/../controllers/EtablissementFondController.php';
require_once __DIR__ . '/../controllers/FondValidationController.php';

Flight::route('GET /etablissementFonds', ['EtablissementFondController', 'getAll']);
Flight::route('POST /etablissementFonds', ['EtablissementFondController', 'create']);

Flight::route('GET /fondValidation', ['FondValidationController', 'getAll']);
Flight::route('POST /fondValidation', ['FondValidationController', 'create']);