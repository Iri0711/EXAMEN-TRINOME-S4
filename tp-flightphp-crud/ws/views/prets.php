<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Types de Prêts</title>
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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Types de Prêts</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadPrets()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Types de Prêts</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Type de Prêt</h2>
            <form id="pretForm" class="space-y-4">
                <input type="hidden" id="pret_id" name="pret_id">
                <div>
                    <label class="block text-gray-700">Libellé :</label>
                    <input type="text" id="libelle" name="libelle" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Taux :</label>
                    <input type="number" step="0.01" id="taux" name="taux" min="0" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Durée (mois) :</label>
                    <input type="number" id="duree" name="duree" min="1" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Types de Prêts</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Libellé</th>
                        <th class="border p-2 text-left">Taux</th>
                        <th class="border p-2 text-left">Durée (mois)</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="pretTableBody"></tbody>
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

        function loadPrets() {
            ajax('GET', '/api/pret_types', null, (prets) => { // Changed from /api/prets to /api/pret_types
                const tbody = document.getElementById('pretTableBody');
                tbody.innerHTML = '';
                prets.forEach(pret => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${pret.id}</td>
                        <td class="border p-2">${pret.libelle}</td>
                        <td class="border p-2">${pret.taux}</td>
                        <td class="border p-2">${pret.duree}</td>
                        <td class="border p-2">
                            <button onclick="editPret(${pret.id}, '${pret.libelle}', ${pret.taux}, ${pret.duree})" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deletePret(${pret.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur lors du chargement des types de prêts:', error);
                alert('Erreur lors du chargement des types de prêts: ' + error);
            });
        }

        function resetForm() {
            document.getElementById('pretForm').reset();
            document.getElementById('pret_id').value = '';
        }

        function editPret(id, libelle, taux, duree) {
            document.getElementById('pret_id').value = id;
            document.getElementById('libelle').value = libelle;
            document.getElementById('taux').value = taux;
            document.getElementById('duree').value = duree;
        }

        function deletePret(id) {
            if (confirm('Voulez-vous vraiment supprimer ce type de prêt ?')) {
                ajax('DELETE', `/api/pret_types/${id}`, null, () => {
                    alert('Type de prêt supprimé avec succès');
                    loadPrets();
                }, (error) => {
                    console.error('Erreur lors de la suppression du type de prêt:', error);
                    alert('Erreur lors de la suppression du type de prêt: ' + error);
                });
            }
        }

        document.getElementById('pretForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('pret_id').value;
            const libelle = document.getElementById('libelle').value;
            const taux = document.getElementById('taux').value;
            const duree = document.getElementById('duree').value;
            const data = `libelle=${encodeURIComponent(libelle)}&taux=${encodeURIComponent(taux)}&duree=${encodeURIComponent(duree)}`;

            if (!libelle || !taux || !duree) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            if (id) {
                ajax('PUT', `/api/pret_types/${id}`, data, () => {
                    alert('Type de prêt mis à jour avec succès');
                    resetForm();
                    loadPrets();
                }, (error) => {
                    console.error('Erreur lors de la mise à jour du type de prêt:', error);
                    alert('Erreur lors de la mise à jour du type de prêt: ' + error);
                });
            } else {
                ajax('POST', `/api/pret_types`, data, () => {
                    alert('Type de prêt créé avec succès');
                    resetForm();
                    loadPrets();
                }, (error) => {
                    console.error('Erreur lors de la création du type de prêt:', error);
                    alert('Erreur lors de la création du type de prêt: ' + error);
                });
            }
        });

        window.onload = loadPrets;
    </script>
</body>
</html>