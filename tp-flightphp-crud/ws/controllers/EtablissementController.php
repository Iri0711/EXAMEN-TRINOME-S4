<?php
require_once __DIR__ . '/../models/Etablissement.php';

class EtablissementController {
    public static function getAll() {
        try {
            $etablissements = Etablissement::getAll();
            Flight::json($etablissements);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des établissements : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $etablissement = Etablissement::getById($id);
            if (!$etablissement) {
                Flight::json(['message' => 'Établissement non trouvé'], 404);
            }
            Flight::json($etablissement);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération de l\'établissement : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->adresse)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = Etablissement::create($data);
            Flight::json(['message' => 'Établissement ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création de l\'établissement : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->adresse)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            Etablissement::update($id, $data);
            Flight::json(['message' => 'Établissement modifié']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour de l\'établissement : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $etablissement = Etablissement::getById($id);
            if (!$etablissement) {
                Flight::json(['message' => 'Établissement non trouvé'], 404);
            }
            Etablissement::delete($id);
            Flight::json(['message' => 'Établissement supprimé']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression de l\'établissement : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>