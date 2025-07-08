<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Établissements</title>
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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Établissements</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadEtablissements()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Établissements</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Établissement</h2>
            <form id="etablissementForm" class="space-y-4">
                <input type="hidden" id="etablissement_id" name="etablissement_id">
                <div>
                    <label class="block text-gray-700">Désignation :</label>
                    <input type="text" id="designation" name="designation" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Établissements</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Désignation</th>
                        <th class="border p-2 text-left">Adresse</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="etablissementTableBody"></tbody>
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

        function loadEtablissements() {
            ajax('GET', '/api/etablissements', null, (etablissements) => {
                const tbody = document.getElementById('etablissementTableBody');
                tbody.innerHTML = '';
                etablissements.forEach(etab => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${etab.id}</td>
                        <td class="border p-2">${etab.designation}</td>
                        <td class="border p-2">${etab.adresse}</td>
                        <td class="border p-2">
                            <button onclick="editEtablissement(${etab.id}, '${etab.designation.replace(/'/g, "\\'")}', '${etab.adresse.replace(/'/g, "\\'")}')" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deleteEtablissement(${etab.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur lors du chargement des établissements:', error);
                alert('Erreur lors du chargement des établissements: ' + error);
            });
        }

        function resetForm() {
            document.getElementById('etablissementForm').reset();
            document.getElementById('etablissement_id').value = '';
        }

        function editEtablissement(id, designation, adresse) {
            document.getElementById('etablissement_id').value = id;
            document.getElementById('designation').value = designation;
            document.getElementById('adresse').value = adresse;
        }

        function deleteEtablissement(id) {
            if (confirm('Voulez-vous vraiment supprimer cet établissement ?')) {
                ajax('DELETE', `/api/etablissements/${id}`, null, () => {
                    alert('Établissement supprimé avec succès');
                    loadEtablissements();
                }, (error) => {
                    console.error('Erreur lors de la suppression de l\'établissement:', error);
                    alert('Erreur lors de la suppression de l\'établissement: ' + error);
                });
            }
        }

        document.getElementById('etablissementForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('etablissement_id').value;
            const designation = document.getElementById('designation').value;
            const adresse = document.getElementById('adresse').value;
            const data = `designation=${encodeURIComponent(designation)}&adresse=${encodeURIComponent(adresse)}`;

            if (!designation || !adresse) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            if (id) {
                ajax('PUT', `/api/etablissements/${id}`, data, () => {
                    alert('Établissement mis à jour avec succès');
                    resetForm();
                    loadEtablissements();
                }, (error) => {
                    console.error('Erreur lors de la mise à jour de l\'établissement:', error);
                    alert('Erreur lors de la mise à jour de l\'établissement: ' + error);
                });
            } else {
                ajax('POST', `/api/etablissements`, data, () => {
                    alert('Établissement créé avec succès');
                    resetForm();
                    loadEtablissements();
                }, (error) => {
                    console.error('Erreur lors de la création de l\'établissement:', error);
                    alert('Erreur lors de la création de l\'établissement: ' + error);
                });
            }
        });

        window.onload = loadEtablissements;
    </script>
</body>
</html>