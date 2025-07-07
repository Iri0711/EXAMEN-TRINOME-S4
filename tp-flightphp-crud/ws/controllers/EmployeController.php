<?php
require_once __DIR__ . '/../models/Employe.php';
require_once __DIR__ . '/../helpers/Utils.php';

class EmployeController {
    public static function getAll() {
        $employes = Employe::getAll();
        Flight::json($employes);
    }

    public static function getById($id) {
        $employe = Employe::getById($id);
        Flight::json($employe);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Employe::create($data);
        Flight::json(['message' => 'Employé ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Employe::update($id, $data);
        Flight::json(['message' => 'Employé modifié']);
    }

    public static function delete($id) {
        Employe::delete($id);
        Flight::json(['message' => 'Employé supprimé']);
    }
}