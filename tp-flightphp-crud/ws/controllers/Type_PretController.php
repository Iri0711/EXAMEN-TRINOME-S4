<?php
require_once __DIR__ . '/../models/Type_Pret.php';

class Type_PretController {
    public static function getAll() {
        try {
            $typePrets = Type_Pret::getAll();
            Flight::json($typePrets);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des types de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $typePret = Type_Pret::getById($id);
            if (!$typePret) {
                Flight::json(['message' => 'Type de prêt non trouvé'], 404);
            }
            Flight::json($typePret);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération du type de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->libelle) || !isset($data->taux) || !isset($data->duree)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = Type_Pret::create($data);
            Flight::json(['message' => 'Type Prêt ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du type de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->libelle) || !isset($data->taux) || !isset($data->duree)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            Type_Pret::update($id, $data);
            Flight::json(['message' => 'Type Prêt modifié']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour du type de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $typePret = Type_Pret::getById($id);
            if (!$typePret) {
                Flight::json(['message' => 'Type de prêt non trouvé'], 404);
            }
            Type_Pret::delete($id);
            Flight::json(['message' => 'Type Prêt supprimé']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression du type de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>