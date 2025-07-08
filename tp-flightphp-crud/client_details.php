<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=banque', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID du client depuis l'URL
$clientId = isset($_GET['clientId']) ? (int)$_GET['clientId'] : 0;

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Client et Prêts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e5e5e5;
        }
        .error {
            color: red;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détails du Client et Prêts</h1>

        <?php if ($client): ?>
            <!-- Détails du client -->
            <div class="card">
                <h2>Informations du Client</h2>
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($client['nom']); ?></p>
                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($client['prenom']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($client['email']); ?></p>
                <p><strong>Contact :</strong> <?php echo htmlspecialchars($client['contact'] ?: 'N/A'); ?></p>
            </div>

            <!-- Liste des prêts -->
            <div class="card">
                <h2>Liste des Prêts</h2>
                <?php if ($prets): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Établissement</th>
                                <th>Taux</th>
                                <th>Durée</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prets as $pret): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pret['id']); ?></td>
                                    <td><?php echo htmlspecialchars($pret['type']); ?></td>
                                    <td><?php echo number_format($pret['montant'], 2); ?> EUR</td>
                                    <td><?php echo htmlspecialchars($pret['date']); ?></td>
                                    <td><?php echo htmlspecialchars($pret['etablissement']); ?></td>
                                    <td><?php echo htmlspecialchars($pret['taux']); ?>%</td>
                                    <td><?php echo htmlspecialchars($pret['duree']); ?> mois</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun prêt trouvé pour ce client.</p>
                <?php endif; ?>
            </div>

            <!-- Bouton Exporter en PDF -->
            <form method="POST" action="generate_pdf.php">
                <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">
                <button type="submit" name="export_pdf" class="btn">Exporter en PDF</button>
            </form>
        <?php else: ?>
            <p class="error">Client non trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>