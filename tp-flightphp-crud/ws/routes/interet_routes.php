<?php

require_once __DIR__ . '/../controllers/InteretController.php';

Flight::route('GET /interetsParMois', ['InteretController', 'getAll']);