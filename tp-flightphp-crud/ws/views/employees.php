<?php
require_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Employés</title>
    <script src="/public/ajax.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Menu latéral -->
    <div class="w-64 bg-white shadow-lg h-screen fixed">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800">Menu</h2>
            <nav class="mt-6">
                <a href="/departements" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Départements</a>
                <a href="/etablissements" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Établissements</a>
                <a href="/type_prets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Types de Prêts</a>
                <a href="/users" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Utilisateurs</a>
                <a href="/clients" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Clients</a>
                <a href="/employees" class="block py-2 px-4 text-white bg-blue-500 rounded">Employés</a>
                <a href="/interets" class="block py-2 px-4 text-gray-700 hover:bg-blue-500 hover:text-white rounded">Intérêts</a>
            </nav>
        </div>
    </div>

    <div class="ml-64 p-8 flex-1">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gérer les Employés</h1>
        
        <div class="mb-6 flex space-x-4">
            <button onclick="loadEmployees()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Charger les Employés</button>
            <button onclick="alert('Fonctionnalité de partage non implémentée')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Share</button>
            <button onclick="resetForm()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reset Data</button>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajouter/Modifier un Employé</h2>
            <form id="employeeForm" class="space-y-4">
                <input type="hidden" id="employee_id" name="employee_id">
                
                <div>
                    <label class="block text-gray-700">ID Utilisateur :</label>
                    <select id="id_user" name="id_user" required class="w-full p-2 border rounded">
                        <option value="">Sélectionnez un utilisateur</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700">ID Département :</label>
                    <select id="id_dept" name="id_dept" required class="w-full p-2 border rounded">
                        <option value="">Sélectionnez un département</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Employés</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">ID Utilisateur</th>
                        <th class="border p-2 text-left">ID Département</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody"></tbody>
            </table>
        </div>

        <footer class="mt-8 text-center text-gray-600">© 2023 Plateforme de Gestion. Tous droits réservés.</footer>
    </div>

    <script>
        function loadEmployees() {
            ajax('GET', '/api/employees', null, (employees) => {
                const tbody = document.getElementById('employeeTableBody');
                tbody.innerHTML = '';
                
                employees.forEach(emp => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${emp.id}</td>
                        <td class="border p-2">${emp.id_user}</td>
                        <td class="border p-2">${emp.id_dept}</td>
                        <td class="border p-2">
                            <button onclick="editEmployee(${emp.id}, ${emp.id_user}, ${emp.id_dept})" 
                                class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifier</button>
                            <button onclick="deleteEmployee(${emp.id})" 
                                class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, (error) => {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement: ' + error);
            });
        }

        function loadUsersAndDepartments() {
            // Charger les utilisateurs
            ajax('GET', '/api/users', null, (users) => {
                const select = document.getElementById('id_user');
                select.innerHTML = '<option value="">Sélectionnez un utilisateur</option>';
                if (users.length === 0) {
                    console.warn('Aucun utilisateur trouvé dans la base de données.');
                } else {
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = `${user.nom} ${user.prenom} (ID: ${user.id})`;
                        select.appendChild(option);
                    });
                }
            }, (error) => {
                console.error('Erreur chargement utilisateurs:', error);
                alert('Erreur lors du chargement des utilisateurs: ' + error);
            });

            // Charger les départements
            ajax('GET', '/api/departements', null, (depts) => {
                const select = document.getElementById('id_dept');
                select.innerHTML = '<option value="">Sélectionnez un département</option>';
                if (depts.length === 0) {
                    console.warn('Aucun département trouvé dans la base de données.');
                } else {
                    depts.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = `${dept.designation} (ID: ${dept.id})`;
                        select.appendChild(option);
                    });
                }
            }, (error) => {
                console.error('Erreur chargement départements:', error);
                alert('Erreur lors du chargement des départements: ' + error);
            });
        }

        function editEmployee(id, id_user, id_dept) {
            document.getElementById('employee_id').value = id;
            document.getElementById('id_user').value = id_user;
            document.getElementById('id_dept').value = id_dept;
        }

        function deleteEmployee(id) {
            if (confirm('Voulez-vous vraiment supprimer cet employé ?')) {
                ajax('DELETE', `/api/employees/${id}`, null, () => {
                    loadEmployees();
                    alert('Employé supprimé');
                }, (error) => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression: ' + error);
                });
            }
        }

        function resetForm() {
            document.getElementById('employeeForm').reset();
            document.getElementById('employee_id').value = '';
        }

        document.getElementById('employeeForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const id = document.getElementById('employee_id').value;
            const id_user = document.getElementById('id_user').value;
            const id_dept = document.getElementById('id_dept').value;
            
            const data = `id_user=${encodeURIComponent(id_user)}&id_dept=${encodeURIComponent(id_dept)}`;
            
            if (id) {
                // Mise à jour
                ajax('PUT', `/api/employees/${id}`, data, () => {
                    alert('Employé mis à jour');
                    resetForm();
                    loadEmployees();
                }, (error) => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour: ' + error);
                });
            } else {
                // Création
                ajax('POST', '/api/employees', data, () => {
                    alert('Employé créé');
                    resetForm();
                    loadEmployees();
                }, (error) => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la création: ' + error);
                });
            }
        });

        // Charger les données au démarrage
        window.onload = function() {
            loadUsersAndDepartments();
            loadEmployees();
        };
    </script>
</body>
</html>