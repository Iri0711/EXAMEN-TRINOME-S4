<?php
require_once __DIR__ . '/../models/Pret_Retour.php';

class Pret_RetourController {
    public static function getAll() {
        try {
            $retours = Pret_Retour::getAll();
            Flight::json($retours);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des retours de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $retour = Pret_Retour::getById($id);
            if (!$retour) {
                Flight::json(['message' => 'Retour de prêt non trouvé'], 404);
            }
            Flight::json($retour);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération du retour de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->id_client_pret) || !isset($data->montant) || !isset($data->date)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = Pret_Retour::create($data);
            Flight::json(['message' => 'Retour de prêt ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du retour de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->id_client_pret) || !isset($data->montant) || !isset($data->date)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            Pret_Retour::update($id, $data);
            Flight::json(['message' => 'Retour de prêt modifié']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour du retour de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $retour = Pret_Retour::getById($id);
            if (!$retour) {
                Flight::json(['message' => 'Retour de prêt non trouvé'], 404);
            }
            Pret_Retour::delete($id);
            Flight::json(['message' => 'Retour de prêt supprimé']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression du retour de prêt : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function calculateInterests() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->capital) || !isset($data->rate) || !isset($data->startDate) || !isset($data->endDate)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $interests = Pret_Retour::calculateInterests($data->capital, $data->rate, $data->startDate, $data->endDate);
            Flight::json(['message' => 'Intérêts calculés', 'data' => $interests], 200);
        } catch (Exception $e) {
            error_log('Erreur lors du calcul des intérêts : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>