<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/Utils.php';

class UserController {
    public static function getAll() {
        $users = User::getAll();
        Flight::json($users);
    }

    public static function getById($id) {
        $user = User::getById($id);
        Flight::json($user);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = User::create($data);
        Flight::json(['message' => 'Utilisateur ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        User::update($id, $data);
        Flight::json(['message' => 'Utilisateur modifié']);
    }

    public static function delete($id) {
        User::delete($id);
        Flight::json(['message' => 'Utilisateur supprimé']);
    }
}