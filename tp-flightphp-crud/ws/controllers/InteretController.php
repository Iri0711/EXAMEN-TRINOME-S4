<?php
require_once 'db.php';

class InteretController {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function calculateInterests($data) {
        $capital = floatval($data['capital']);
        $rate = floatval($data['rate']) / 100; // Taux annuel en décimal
        $startDate = new DateTime($data['startDate'] . '-01');
        $endDate = new DateTime($data['endDate'] . '-01');

        if (!$capital || !$rate || !$startDate || !$endDate || $startDate > $endDate) {
            return ['error' => 'Veuillez vérifier les entrées.'];
        }

        $interests = [];
        $currentCapital = $capital;
        $date = clone $startDate;

        while ($date <= $endDate) {
            $monthlyRate = $rate / 12;
            $interest = $currentCapital * $monthlyRate;
            $currentCapital += $interest;

            $interests[] = [
                'month' => $date->format('F Y'),
                'interest' => number_format($interest, 2),
                'capital' => number_format($currentCapital, 2)
            ];

            $date->modify('+1 month');
        }

        return $interests;
    }

    public function saveInterests($interests, $data) {
        // Préparer une insertion en base de données (exemple, table 'Interets' à créer si nécessaire)
        $stmt = $this->db->prepare("INSERT INTO Interets (capital_initial, taux, start_date, end_date, details, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $details = json_encode($interests);
        $stmt->execute([$data['capital'], $data['rate'], $data['startDate'], $data['endDate'], $details]);
        return ['message' => 'Intérêts enregistrés', 'id' => $this->db->lastInsertId()];
    }

    public function getInterests() {
        $stmt = $this->db->query("SELECT * FROM Interets ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>