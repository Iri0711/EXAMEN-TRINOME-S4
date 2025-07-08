<?php

require_once __DIR__ . '/../db.php';

class Retour {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Pret_Retour");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Pret_Retour (id_client_pret, montant, date) VALUES (?, ?, ?)");
        $stmt->execute([$data->id_client_pret, $data->montant, $data->date]);
        return $db->lastInsertId();
    }


    public static function getRemainingBalances() {
        try {
            $db = getDB();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->query("
                SELECT 
                    c.id AS client_id,
                    u.nom AS client_nom,
                    u.prenom AS client_prenom,
                    pc.id AS pret_id,
                    pc.montant AS montant_pret,
                    pt.taux AS taux_interet,
                    pt.duree AS duree_jours,
                    COALESCE(SUM(pr.montant), 0) AS montant_rembourse
                FROM Client c
                JOIN User u ON c.id_user = u.id
                JOIN Pret_Client pc ON c.id = pc.id_client
                JOIN Pret_Type pt ON pc.id_pret_type = pt.id
                LEFT JOIN Pret_Retour pr ON pc.id = pr.id_client_pret
                GROUP BY c.id, u.nom, u.prenom, pc.id, pc.montant, pt.taux, pt.duree
            ");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculer l'annuité constante et le montant restant
            $clients = [];
            foreach ($results as $row) {
                $client_id = $row['client_id'];
                $pret_id = $row['pret_id'];
                $montant_pret = (float)$row['montant_pret'];
                $taux = (float)$row['taux_interet'] / 100; // Taux annuel en décimal
                $duree_jours = (int)$row['duree_jours'];
                $duree_annees = $duree_jours / 365; // Convertir la durée en années
                $montant_rembourse = (float)$row['montant_rembourse'];

                // Calcul de l'annuité constante (annuelle)
                if ($taux > 0 && $duree_annees > 0) {
                    $annuite = $montant_pret * ($taux * pow(1 + $taux, $duree_annees)) / (pow(1 + $taux, $duree_annees) - 1);
                } else {
                    $annuite = $montant_pret / max(1, $duree_annees); // Cas sans intérêt ou durée nulle
                }

                // Montant total dû (annuité * durée en années)
                $montant_total_du = $annuite * $duree_annees;

                // Montant restant
                $montant_restant = max(0, $montant_total_du - $montant_rembourse);

                // Regrouper par client
                if (!isset($clients[$client_id])) {
                    $clients[$client_id] = [
                        'client_id' => $client_id,
                        'nom' => $row['client_nom'],
                        'prenom' => $row['client_prenom'],
                        'montant_restant_total' => 0,
                        'prets' => []
                    ];
                }
                $clients[$client_id]['montant_restant_total'] += $montant_restant;
                $clients[$client_id]['prets'][] = [
                    'pret_id' => $pret_id,
                    'montant_pret' => $montant_pret,
                    'taux_interet' => $row['taux_interet'],
                    'duree_jours' => $duree_jours,
                    'montant_rembourse' => $montant_rembourse,
                    'montant_restant' => $montant_restant
                ];
            }

            // Convertir en tableau indexé pour JSON
            return array_values($clients);
        } catch (PDOException $e) {
            error_log('Erreur SQL : ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Erreur lors de la récupération des soldes : ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            error_log('Erreur inattendue : ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Erreur inattendue lors de la récupération des soldes'
            ];
        }
    }
}