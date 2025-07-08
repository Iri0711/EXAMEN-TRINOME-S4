<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Utilisateurs</title>
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
                <a hurdles="/prets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Types de Prêts</a>
                <a href="/users" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Utilisateurs</a>
                <a href="/clients" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Clients</a>
                <a href="/employees" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Employés</a>
                <a href="/interets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Intérêts</a>
            </nav>
        </div>
    </div>

    <div class="ml-64 p-8 flex-1">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Utilisateurs</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadUsers()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Utilisateurs</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Utilisateur</h2>
            <form id="userForm" action="/api/users" method="POST" class="space-y-4">
                <input type="hidden" id="user_id" name="user_id">
                <div>
                    <label class="block text-gray-700">Nom :</label>
                    <input type="text" id="nom" name="nom" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Contact :</label>
                    <input type="text" id="contact" name="contact" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Email :</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Utilisateurs</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Nom</th>
                        <th class="border p-2 text-left">Prénom</th>
                        <th class="border p-2 text-left">Contact</th>
                        <th class="border p-2 text-left">Email</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody"></tbody>
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

        function loadUsers() {
            ajax('GET', '/api/users', null, (users) => {
                const tbody = document.getElementById('userTableBody');
                tbody.innerHTML = '';
                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${user.id}</td>
                        <td class="border p-2">${user.nom}</td>
                        <td class="border p-2">${user.prenom}</td>
                        <td class="border p-2">${user.contact}</td>
                        <td class="border p-2">${user.email}</td>
                        <td class="border p-2">
                            <button onclick="editUser(${user.id}, '${user.nom}', '${user.prenom}', '${user.contact}', '${user.email}')" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deleteUser(${user.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur lors du chargement des utilisateurs:', error);
                alert('Erreur lors du chargement des utilisateurs: ' + error);
            });
        }

        function resetForm() {
            document.getElementById('userForm').reset();
            document.getElementById('user_id').value = '';
        }

        function editUser(id, nom, prenom, contact, email) {
            document.getElementById('user_id').value = id;
            document.getElementById('nom').value = nom;
            document.getElementById('prenom').value = prenom;
            document.getElementById('contact').value = contact;
            document.getElementById('email').value = email;
            document.getElementById('mdp').value = '';
        }

        function deleteUser(id) {
            if (confirm('Voulez-vous vraiment supprimer cet utilisateur ?')) {
                ajax('DELETE', `/api/users/${id}`, null, () => {
                    loadUsers();
                    alert('Utilisateur supprimé');
                }, (error) => {
                    console.error('Erreur lors de la suppression:', error);
                    alert('Erreur lors de la suppression: ' + error);
                });
            }
        }

        document.getElementById('userForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const id = document.getElementById('user_id').value;
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const contact = document.getElementById('contact').value;
            const email = document.getElementById('email').value;
            const mdp = document.getElementById('mdp').value;
            
            const data = `nom=${encodeURIComponent(nom)}&prenom=${encodeURIComponent(prenom)}&contact=${encodeURIComponent(contact)}&email=${encodeURIComponent(email)}&mdp=${encodeURIComponent(mdp)}`;
            
            console.log('Submitting form with data:', data); // Debugging
            
            if (id) {
                // Mise à jour
                ajax('PUT', `/api/users/${id}`, data, () => {
                    alert('Utilisateur mis à jour');
                    resetForm();
                    loadUsers();
                }, (error) => {
                    console.error('Erreur lors de la mise à jour:', error);
                    alert('Erreur lors de la mise à jour: ' + error);
                });
            } else {
                // Création
                ajax('POST', '/api/users', data, () => {
                    alert('Utilisateur créé');
                    resetForm();
                    loadUsers();
                }, (error) => {
                    console.error('Erreur lors de la création:', error);
                    alert('Erreur lors de la création: ' + error);
                });
            }
        });

        // Charger les données au démarrage
        window.onload = loadUsers;
    </script>
</body>
</html>