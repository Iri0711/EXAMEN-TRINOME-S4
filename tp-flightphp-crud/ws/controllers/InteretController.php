<?php
require_once __DIR__ . '/../models/Interet.php';
require_once __DIR__ . '/../helpers/Utils.php';

class InteretController {
    public static function getAll() {
        error_log("ICI COMMENCE");
        try {
            // Récupération des paramètres (fonctionne pour GET et POST)
            $request = Flight::request();
            $params = $request->method === 'GET' ? $request->query : $request->data;
            error_log(json_encode($params));
            // Validation des paramètres
            if (empty($params['debut']) || empty($params['fin'])) {
                Flight::halt(400, json_encode([
                    'error' => 'Les paramètres "debut" et "fin" sont requis'
                ]));
                return;
            }
            
         
            
            // Appel au modèle
            $resultats = Interet::getAll((object)$params);
            
            // Vérification des résultats
            if (empty($resultats)) {
                Flight::halt(404, json_encode([
                    'error' => 'Aucune donnée trouvée pour cette période'
                ]));
                return;
            }
            
            // Réponse JSON
            Flight::json([
                'success' => true,
                'data' => $resultats,
                'periode' => [
                    'debut' => $params['debut'],
                    'fin' => $params['fin']
                ]
            ]);
            
        } catch (Exception $e) {
            // Journalisation de l'erreur (à implémenter)
            error_log($e->getMessage());
            
            Flight::halt(500, json_encode([
                'error' => 'Erreur serveur',
                'message' => $e->getMessage()
            ]));
        }
    }
}