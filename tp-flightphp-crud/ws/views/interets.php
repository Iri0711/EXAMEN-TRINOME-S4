<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Intérêts</title>
    <script src="/public/ajax.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <div class="w-64 bg-white shadow-lg h-screen fixed">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800">Menu</h2>
            <nav class="mt-6">
                <a href="/departements" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Départements</a>
                <a href="/etablissements" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Établissements</a>
                <a href="/prets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Types de Prêts</a>
                <a href="/users" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Utilisateurs</a>
                <a href="/clients" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Clients</a>
                <a href="/employees" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Employés</a>
                <a href="/interets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Intérêts</a>
            </nav>
        </div>
    </div>

    <div class="ml-64 p-8 flex-1">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Intérêts</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadInterets()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Intérêts</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Intérêt</h2>
            <form id="interetForm" class="space-y-4">
                <input type="hidden" id="interet_id" name="interet_id">
                <div>
                    <label class="block text-gray-700">Mois :</label>
                    <input type="number" id="mois" name="mois" min="1" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Intérêts (€) :</label>
                    <input type="number" step="0.01" id="interets" name="interets" min="0" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Capital Cumulé (€) :</label>
                    <input type="number" step="0.01" id="capital_cumule" name="capital_cumule" min="0" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Intérêts</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Mois</th>
                        <th class="border p-2 text-left">Intérêts (€)</th>
                        <th class="border p-2 text-left">Capital Cumulé (€)</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="interetTableBody"></tbody>
            </table>
        </div>

        <footer class="mt-8 text-center text-gray-600">© 2023 Plateforme de Gestion. Tous droits réservés.</footer>
    </div>

    <script>
        if (typeof ajax !== 'function') {
            console.error('Erreur : la fonction ajax n\'est pas définie. Vérifiez le chargement de /public/ajax.js');
            alert('Erreur : Impossible de charger ajax.js.');
            throw new Error('Fonction ajax non définie');
        }

        function loadInterets() {
            ajax('GET', '/api/interets', null, (interets) => {
                const tbody = document.getElementById('interetTableBody');
                tbody.innerHTML = '';
                interets.forEach(interet => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${interet.id}</td>
                        <td class="border p-2">${interet.mois}</td>
                        <td class="border p-2">${interet.interets}</td>
                        <td class="border p-2">${interet.capital_cumule}</td>
                        <td class="border p-2">
                            <button onclick="editInteret(${interet.id}, ${interet.mois}, ${interet.interets}, ${interet.capital_cumule})" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deleteInteret(${interet.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur lors du chargement des intérêts:', error);
                alert('Erreur lors du chargement des intérêts: ' + error);
            });
        }

        function resetForm() {
            document.getElementById('interetForm').reset();
            document.getElementById('interet_id').value = '';
        }

        function editInteret(id, mois, interets, capital_cumule) {
            document.getElementById('interet_id').value = id;
            document.getElementById('mois').value = mois;
            document.getElementById('interets').value = interets;
            document.getElementById('capital_cumule').value = capital_cumule;
        }

        function deleteInteret(id) {
            if (confirm('Voulez-vous vraiment supprimer cet intérêt ?')) {
                ajax('DELETE', `/api/interets/${id}`, null, () => {
                    alert('Intérêt supprimé avec succès');
                    loadInterets();
                }, (error) => {
                    console.error('Erreur lors de la suppression de l\'intérêt:', error);
                    alert('Erreur lors de la suppression de l\'intérêt: ' + error);
                });
            }
        }

        document.getElementById('interetForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('interet_id').value;
            const mois = document.getElementById('mois').value;
            const interets = document.getElementById('interets').value;
            const capital_cumule = document.getElementById('capital_cumule').value;
            const data = `mois=${encodeURIComponent(mois)}&interets=${encodeURIComponent(interets)}&capital_cumule=${encodeURIComponent(capital_cumule)}`;

            if (!mois || !interets || !capital_cumule) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            if (id) {
                ajax('PUT', `/api/interets/${id}`, data, () => {
                    alert('Intérêt mis à jour avec succès');
                    resetForm();
                    loadInterets();
                }, (error) => {
                    console.error('Erreur lors de la mise à jour de l\'intérêt:', error);
                    alert('Erreur lors de la mise à jour de l\'intérêt: ' + error);
                });
            } else {
                ajax('POST', `/api/interets`, data, () => {
                    alert('Intérêt créé avec succès');
                    resetForm();
                    loadInterets();
                }, (error) => {
                    console.error('Erreur lors de la création de l\'intérêt:', error);
                    alert('Erreur lors de la création de l\'intérêt: ' + error);
                });
            }
        });

        window.onload = loadInterets;
    </script>
</body>
</html>