<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Départements</title>
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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Départements</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadDepartments()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Départements</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Département</h2>
            <form id="departmentForm" class="space-y-4">
                <input type="hidden" id="department_id" name="department_id">
                <div>
                    <label class="block text-gray-700">Désignation :</label>
                    <input type="text" id="designation" name="designation" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Autorisé :</label>
                    <div class="flex space-x-4">
                        <label><input type="radio" name="autorise" value="1" required> Oui</label>
                        <label><input type="radio" name="autorise" value="0"> Non</label>
                    </div>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Départements</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Désignation</th>
                        <th class="border p-2 text-left">Autorisé</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="departmentTableBody"></tbody>
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

        function loadDepartments() {
            ajax('GET', '/api/departements', null, (departments) => {
                const tbody = document.getElementById('departmentTableBody');
                tbody.innerHTML = '';
                departments.forEach(dept => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${dept.id}</td>
                        <td class="border p-2">${dept.designation}</td>
                        <td class="border p-2">${dept.autorise ? 'Oui' : 'Non'}</td>
                        <td class="border p-2">
                            <button onclick="editDepartment(${dept.id}, '${dept.designation}', ${dept.autorise})" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deleteDepartment(${dept.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur lors du chargement des départements:', error);
                alert('Erreur lors du chargement des départements: ' + error);
            });
        }

        function resetForm() {
            document.getElementById('departmentForm').reset();
            document.getElementById('department_id').value = '';
        }

        function editDepartment(id, designation, autorise) {
            document.getElementById('department_id').value = id;
            document.getElementById('designation').value = designation;
            document.querySelector(`input[name="autorise"][value="${autorise}"]`).checked = true;
        }

        function deleteDepartment(id) {
            if (confirm('Voulez-vous vraiment supprimer ce département ?')) {
                ajax('DELETE', `/api/departements/${id}`, null, () => {
                    alert('Département supprimé avec succès');
                    loadDepartments();
                }, (error) => {
                    console.error('Erreur lors de la suppression du département:', error);
                    alert('Erreur lors de la suppression du département: ' + error);
                });
            }
        }

        document.getElementById('departmentForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('department_id').value;
            const designation = document.getElementById('designation').value;
            const autorise = document.querySelector('input[name="autorise"]:checked')?.value;
            const data = `designation=${encodeURIComponent(designation)}&autorise=${encodeURIComponent(autorise)}`;

            if (!designation || !autorise) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            if (id) {
                ajax('PUT', `/api/departements/${id}`, data, () => {
                    alert('Département mis à jour avec succès');
                    resetForm();
                    loadDepartments();
                }, (error) => {
                    console.error('Erreur lors de la mise à jour du département:', error);
                    alert('Erreur lors de la mise à jour du département: ' + error);
                });
            } else {
                ajax('POST', `/api/departements`, data, () => {
                    alert('Département créé avec succès');
                    resetForm();
                    loadDepartments();
                }, (error) => {
                    console.error('Erreur lors de la création du département:', error);
                    alert('Erreur lors de la création du département: ' + error);
                });
            }
        });

        window.onload = loadDepartments;
    </script>
</body>
</html>