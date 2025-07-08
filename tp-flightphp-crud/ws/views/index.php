<?php
    // require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Gestion</title>
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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Plateforme de Gestion</h1>
        <div class="mb-6 flex space-x-4">
            <button onclick="loadStats()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualiser</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetStats()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800">Total Users</h2>
                <p id="totalUsers" class="text-3xl font-bold text-blue-500">0</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800">Active Loans</h2>
                <p id="activeLoans" class="text-3xl font-bold text-blue-500">0</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800">Total Departments</h2>
                <p id="totalDepartments" class="text-3xl font-bold text-blue-500">0</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Activity Overview</h2>
            <!-- Placeholder pour graphique ou autre visualisation -->
            <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
                <p class="text-gray-500">Graphique en construction</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activities</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">Activity</th>
                        <th class="border p-2 text-left">Date</th>
                        <th class="border p-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="activityTableBody">
                    <tr>
                        <td class="border p-2">User Added</td>
                        <td class="border p-2">2025-07-07</td>
                        <td class="border p-2">Completed</td>
                    </tr>
                    <tr>
                        <td class="border p-2">Loan Approved</td>
                        <td class="border p-2">2025-07-06</td>
                        <td class="border p-2">Completed</td>
                    </tr>
                </tbody>
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

        function loadStats() {
            ajax('GET', '/api/users', null, (users) => {
                document.getElementById('totalUsers').textContent = users.length;
            }, (error) => {
                console.error('Erreur lors du chargement des utilisateurs:', error);
                alert('Erreur lors du chargement des utilisateurs: ' + error);
            });

            ajax('GET', '/api/prets', null, (prets) => {
                document.getElementById('activeLoans').textContent = prets.length;
            }, (error) => {
                console.error('Erreur lors du chargement des prêts:', error);
                alert('Erreur lors du chargement des prêts: ' + error);
            });

            ajax('GET', '/api/departements', null, (departements) => {
                document.getElementById('totalDepartments').textContent = departements.length;
            }, (error) => {
                console.error('Erreur lors du chargement des départements:', error);
                alert('Erreur lors du chargement des départements: ' + error);
            });
        }

        function resetStats() {
            document.getElementById('totalUsers').textContent = '0';
            document.getElementById('activeLoans').textContent = '0';
            document.getElementById('totalDepartments').textContent = '0';
        }

        window.onload = loadStats;
    </script>
</body>
</html>