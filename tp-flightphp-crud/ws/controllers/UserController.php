<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    public static function getAll() {
        try {
            $users = User::getAll();
            Flight::json($users);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération des utilisateurs : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function getById($id) {
        try {
            $user = User::getById($id);
            if (!$user) {
                Flight::json(['message' => 'Utilisateur non trouvé'], 404);
            }
            Flight::json($user);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération de l\'utilisateur : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mdp)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            $id = User::create($data);
            Flight::json(['message' => 'Utilisateur ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            error_log('Erreur lors de la création de l\'utilisateur : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mdp)) {
                Flight::json(['message' => 'Champs requis manquants'], 400);
            }
            User::update($id, $data);
            Flight::json(['message' => 'Utilisateur modifié']);
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }

    public static function delete($id) {
        try {
            $user = User::getById($id);
            if (!$user) {
                Flight::json(['message' => 'Utilisateur non trouvé'], 404);
            }
            User::delete($id);
            Flight::json(['message' => 'Utilisateur supprimé']);
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage());
            Flight::json(['message' => 'Erreur serveur'], 500);
        }
    }
}
?>