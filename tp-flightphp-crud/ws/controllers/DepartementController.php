<?php
require_once __DIR__ . '/../models/Departement.php';

class DepartementController {
    public function getAll() {
        try {
            $departements = Departement::getAll();
            Flight::json($departements);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des départements : ' . $e->getMessage());
            Flight::halt(500, json_encode(['erreur' => 'Erreur serveur lors de la récupération des départements']));
        }
    }

    public function getById($id) {
        try {
            $departement = Departement::getById($id);
            if (!$departement) {
                Flight::halt(404, json_encode(['erreur' => 'Département non trouvé']));
            }
            Flight::json($departement);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération du département : ' . $e->getMessage());
            Flight::halt(500, json_encode(['erreur' => 'Erreur serveur lors de la récupération du département']));
        }
    }

    public function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->autorise)) {
                Flight::halt(400, json_encode(['erreur' => 'Champs requis manquants']));
            }
            $id = Departement::create($data);
            Flight::json(['id' => $id, 'message' => 'Département créé avec succès'], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du département : ' . $e->getMessage());
            Flight::halt(500, json_encode(['erreur' => 'Erreur serveur lors de la création du département']));
        }
    }

    public function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->designation) || !isset($data->autorise)) {
                Flight::halt(400, json_encode(['erreur' => 'Champs requis manquants']));
            }
            Departement::update($id, $data);
            Flight::json(['message' => 'Département mis à jour avec succès']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour du département : ' . $e->getMessage());
            Flight::halt(500, json_encode(['erreur' => 'Erreur serveur lors de la mise à jour du département']));
        }
    }

    public function delete($id) {
        try {
            $departement = Departement::getById($id);
            if (!$departement) {
                Flight::halt(404, json_encode(['erreur' => 'Département non trouvé']));
            }
            Departement::delete($id);
            Flight::json(['message' => 'Département supprimé avec succès']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression du département : ' . $e->getMessage());
            Flight::halt(500, json_encode(['erreur' => 'Erreur serveur lors de la suppression du département']));
        }
    }
}
?>