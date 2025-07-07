<?php
require_once __DIR__ . '/../models/Employe.php';

class EmployeController {
    public static function getAll() {
        try {
            $employes = Employe::getAll();
            Flight::json($employes);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des employés : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $employe = Employe::getById($id);
            if (!$employe) {
                Flight::json(['message' => 'Employé non trouvé'], 404);
            }
            Flight::json($employe);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération de l\'employé : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->id_user) || !isset($data->id_dept)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = Employe::create($data);
            Flight::json(['message' => 'Employé ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création de l\'employé : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->id_user) || !isset($data->id_dept)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            Employe::update($id, $data);
            Flight::json(['message' => 'Employé modifié']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour de l\'employé : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $employe = Employe::getById($id);
            if (!$employe) {
                Flight::json(['message' => 'Employé non trouvé'], 404);
            }
            Employe::delete($id);
            Flight::json(['message' => 'Employé supprimé']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression de l\'employé : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>