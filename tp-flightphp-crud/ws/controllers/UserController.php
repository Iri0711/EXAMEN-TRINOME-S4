<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/Utils.php';

class UserController {
    public static function getAll() {
        error_log("USER AOA");
        $prets = User::getAll();
        Flight::json([
                'success' => true,
                'data' => $prets
            ]);
    }

    public static function getById($id) {
        $pret = User::getById($id);
        Flight::json($pret);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = User::create($data);
        Flight::json(['success'=>true,'message' => 'user ajouté', 'id' => $id]);
    }

    public static function update($id) {
        error_log("UPDATE");
        $data = Flight::request()->data;
        User::update($id, $data);
        Flight::json(['success'=>true,'message' => 'User modifié']);
    }

    public static function delete($id) {
        User::delete($id);
        Flight::json(['success'=>true,'message' => 'User supprimé']);
    }
}