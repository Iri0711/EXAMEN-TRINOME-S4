<?php
// interets.php - Fichier facultatif pour logique serveur future
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Intérêts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        canvas { margin-top: 20px; }
        .filters { margin-bottom: 20px; }
        a { display: block; margin-bottom: 20px; color: #007BFF; text-decoration: none; }
        a:hover { text-decoration: underline; }
        input, button { margin: 5px; padding: 5px; }
        button { background-color: #007BFF; color: white; border: none; padding: 10px 20px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Intérêts</h1>
        <a href="/">Retour à l'accueil</a>
        
        <h2>Calculer les Intérêts</h2>
        <div class="filters">
            <label>Capital Initial (€): <input type="number" id="capital" value="10000"></label>
            <label>Taux d'Intérêt Annuel (%): <input type="number" id="rate" value="2.5" step="0.1"></label><br>
            <label>Date Début: <input type="month" id="startDate"></label>
            <label>Date Fin: <input type="month" id="endDate"></label>
            <button onclick="calculateInterests()">Enregistrer</button>
        </div>

        <h2>Liste des Intérêts</h2>
        <table id="interestTable">
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Intérêts (€)</th>
                    <th>Capital Cumulé (€)</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
        <canvas id="interestChart"></canvas>
    </div>

    <script>
        let chartInstance = null;

        function calculateInterests() {
            const capital = parseFloat(document.getElementById('capital').value);
            const rate = parseFloat(document.getElementById('rate').value) / 100;
            const startDate = new Date(document.getElementById('startDate').value + '-01');
            const endDate = new Date(document.getElementById('endDate').value + '-01');
            
            if (!capital || !rate || isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                alert('Veuillez vérifier les entrées.');
                return;
            }

            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';
            const labels = [];
            const interestsData = [];
            let currentCapital = capital;

            for (let date = new Date(startDate); date <= endDate; date.setMonth(date.getMonth() + 1)) {
                const monthlyRate = rate / 12;
                const interest = currentCapital * monthlyRate;
                currentCapital += interest;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${date.toLocaleString('fr-FR', { month: 'long', year: 'numeric' })}</td>
                    <td>${interest.toFixed(2)}</td>
                    <td>${currentCapital.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);

                labels.push(date.toLocaleString('fr-FR', { month: 'short', year: 'numeric' }));
                interestsData.push(interest);
            }

            if (chartInstance) {
                chartInstance.destroy();
            }

            const ctx = document.getElementById('interestChart').getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Intérêts Mensuels (€)',
                        data: interestsData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Intérêts (€)' }
                        },
                        x: {
                            title: { display: true, text: 'Mois' }
                        }
                    }
                }
            });
        }

        // Définir les dates par défaut (dernier an)
        const today = new Date();
        const lastYear = new Date(today.getFullYear() - 1, today.getMonth());
        document.getElementById('startDate').value = lastYear.toISOString().slice(0, 7);
        document.getElementById('endDate').value = today.toISOString().slice(0, 7);
    </script>
</body>
</html>