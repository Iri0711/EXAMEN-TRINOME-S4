<?php
require_once __DIR__ . '/fpdf/fpdf.php'; // Inclure FPDF

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=banque', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID du client depuis le formulaire
$clientId = isset($_POST['clientId']) ? (int)$_POST['clientId'] : 0;

// Récupérer les détails du client
$stmt = $pdo->prepare("
    SELECT u.nom, u.prenom, u.email, u.contact
    FROM Client c
    JOIN User u ON c.id_user = u.id
    WHERE c.id = :clientId
");
$stmt->execute(['clientId' => $clientId]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les prêts du client
$stmt = $pdo->prepare("
    SELECT pc.id, pt.libelle AS type, pc.montant, pc.date, e.designation AS etablissement, pt.taux, pt.duree
    FROM Pret_Client pc
    JOIN Pret_Type pt ON pc.id_pret_type = pt.id
    JOIN Etablissement e ON pc.id_etab = e.id
    WHERE pc.id_client = :clientId
");
$stmt->execute(['clientId' => $clientId]);
$prets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Générer le PDF si le bouton est cliqué
if (isset($_POST['export_pdf']) && $client) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Titre
    $pdf->Cell(0, 10, 'Détails du Client et Prêts', 0, 1, 'C');
    $pdf->Ln(10);

    // Détails du client
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informations du Client', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nom: ' . ($client['nom'] ?? 'N/A'), 0, 1);
    $pdf->Cell(0, 10, 'Prénom: ' . ($client['prenom'] ?? 'N/A'), 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . ($client['email'] ?? 'N/A'), 0, 1);
    $pdf->Cell(0, 10, 'Contact: ' . ($client['contact'] ?? 'N/A'), 0, 1);
    $pdf->Ln(10);

    // Tableau des prêts
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Liste des Prêts', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Type', 1);
    $pdf->Cell(30, 10, 'Montant', 1);
    $pdf->Cell(30, 10, 'Date', 1);
    $pdf->Cell(40, 10, 'Établissement', 1);
    $pdf->Cell(20, 10, 'Taux', 1);
    $pdf->Cell(20, 10, 'Durée', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    foreach ($prets as $pret) {
        $pdf->Cell(20, 10, $pret['id'], 1);
        $pdf->Cell(40, 10, $pret['type'], 1);
        $pdf->Cell(30, 10, number_format($pret['montant'], 2) . ' EUR', 1);
        $pdf->Cell(30, 10, $pret['date'], 1);
        $pdf->Cell(40, 10, $pret['etablissement'], 1);
        $pdf->Cell(20, 10, $pret['taux'] . '%', 1);
        $pdf->Cell(20, 10, $pret['duree'] . ' mois', 1);
        $pdf->Ln();
    }

    // Sortie du PDF
    $pdf->Output('D', 'Details_Client_' . $clientId . '.pdf');
    exit;
} else {
    // Rediriger si aucun client n'est trouvé
    header('Location: client_details.php?clientId=' . $clientId);
    exit;
}
?>