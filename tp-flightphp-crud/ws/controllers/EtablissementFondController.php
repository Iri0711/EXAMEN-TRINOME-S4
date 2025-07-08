<?php

require_once __DIR__ . '/../models/EtablissementFond.php';
require_once __DIR__ . '/../helpers/Utils.php';

class EtablissementFondController {
    public static function getAll() {
        $etablissements = EtablissementFond::getAll();
        Flight::json($etablissements);
    }

    public static function getById($id) {
        $etablissement = EtablissementFond::getById($id);
        Flight::json($etablissement);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = EtablissementFond::create($data);
        Flight::json(['message' => 'Établissement ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        EtablissementFond::update($id, $data);
        Flight::json(['message' => 'Établissement modifié']);
    }

    public static function delete($id) {
        EtablissementFond::delete($id);
        Flight::json(['message' => 'Établissement supprimé']);
    }
}