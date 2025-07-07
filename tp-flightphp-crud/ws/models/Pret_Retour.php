<?php
require_once __DIR__ . '/../db.php';

class Pret_Retour {
    public static function getAll() {
        try {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM Pret_Retour");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Pret Retours: " . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM Pret_Retour WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching Pret Retour by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Pret_Retour (id_client_pret, montant, date) VALUES (?, ?, ?)");
            $stmt->execute([$data->id_client_pret, $data->montant, $data->date]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating Pret Retour: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $db = getDB();
            $stmt = $db->prepare("UPDATE Pret_Retour SET id_client_pret = ?, montant = ?, date = ? WHERE id = ?");
            $stmt->execute([$data->id_client_pret, $data->montant, $data->date, $id]);
        } catch (PDOException $e) {
            error_log("Error updating Pret Retour: " . $e->getMessage());
        }
    }

    public static function delete($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM Pret_Retour WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting Pret Retour: " . $e->getMessage());
        }
    }

    public static function calculateInterests($capital, $rate, $startDate, $endDate) {
        try {
            $db = getDB();
            $monthlyRate = $rate / 12 / 100;
            $currentCapital = $capital;
            $interests = [];

            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $interval = new DateInterval('P1M');
            $period = new DatePeriod($start, $interval, $end);

            foreach ($period as $date) {
                $interest = $currentCapital * $monthlyRate;
                $currentCapital += $interest;
                $interests[] = [
                    'month' => $date->format('Y-m'),
                    'interest' => $interest,
                    'capital' => $currentCapital
                ];
            }

            return $interests;
        } catch (Exception $e) {
            error_log("Error calculating interests: " . $e->getMessage());
            return [];
        }
    }
}
?>