<?php
require_once __DIR__ . '/../models/Departement.php';

class DepartementController {
    public static function getAll() {
        try {
            $departements = Departement::getAll();
            Flight::json($departements);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des départements : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $departement = Departement::getById($id);
            if (!$departement) {
                Flight::json(['message' => 'Département non trouvé'], 404);
            }
            Flight::json($departement);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération du département : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->autorise)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = Departement::create($data);
            Flight::json(['message' => 'Département créé avec succès', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du département : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->autorise)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            Departement::update($id, $data);
            Flight::json(['message' => 'Département mis à jour avec succès']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour du département : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $departement = Departement::getById($id);
            if (!$departement) {
                Flight::json(['message' => 'Département non trouvé'], 404);
            }
            Departement::delete($id);
            Flight::json(['message' => 'Département supprimé avec succès']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression du département : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>