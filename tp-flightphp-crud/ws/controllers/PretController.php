<?php
require_once __DIR__ . '/../models/Type_pret.php';
require_once __DIR__ . '/../models/Pret.php';
require_once __DIR__ . '/../helpers/Utils.php';
require_once __DIR__ . '/../models/Retour.php';

class PretController {


    // TOUT LES PRETS
    public static function getAllPrets() {
        $prets = Pret::getAll();
        Flight::json($prets);
    }

    public static function createPret() {
        error_log("CREATE PRET CALLED");
        error_log("Request Data: " . json_encode(Flight::request()->data));

        $data = Flight::request()->data;
        $result = Pret::create($data);
        
        if ($result['success']) {
            Flight::json([
                'message' => $result['message'],
                'id' => $result['id']
            ], 201);
        } else {
            Flight::json(['error' => $result['error']], 400);
        }
    }

    // TYPES DE PRET
    public static function getAllTypesPret() {
        $types = Type_pret::getAll();
        Flight::json($types);
    }

    // public static function getById($id) {
    //     $pret = Type_pret::getById($id);
    //     Flight::json($pret);
    

    public static function createTypePret() {
        $data = Flight::request()->data;
        $id = Type_pret::create($data);
        Flight::json(['message' => 'Type de prêt ajouté', 'id' => $id]);
    }



    /// RETOUR DES PRETS

    public static function getAllRetours() {
        $retours = Retour::getAll();
        Flight::json($retours);
    }
    public static function createRetour() {
        $data = Flight::request()->data;
        $id = Retour::create($data);
        Flight::json(['message' => 'Retour de prêt ajouté', 'id' => $id]);
    }


    // REMAINING PAYEMENTS

     public static function getRemainingBalances() {
        $result = Retour::getRemainingBalances();
        if (isset($result['success']) && !$result['success']) {
            Flight::json(['error' => $result['error']], 500);
        } else {
            Flight::json($result);
        }
    }
}