// Données simulées pour chaque entité
let departements = [
    { id: 1, nom: "Administration", description: "Département administratif", responsable: "Dr. Dupont" },
    { id: 2, nom: "Finance", description: "Département financier", responsable: "Mme. Martin" }
];

let etablissements = [
    { id: 1, nom: "Banque Centrale", adresse: "123 Rue de la Finance, Paris", ville: "Paris", code_postal: "75001" },
    { id: 2, nom: "Agence Lyon", adresse: "456 Avenue Test", ville: "Lyon", code_postal: "69001" }
];

let prets = [
    { id: 1, id_client: 1, id_etab: 1, id_pret_type: 1, montant: 50000.00, date: "2025-07-03" },
    { id: 2, id_client: 2, id_etab: 1, id_pret_type: 1, montant: 75000.00, date: "2025-07-04" }
];

// Fonction pour afficher les données dans un tableau
function displayData(tableId, data, fields) {
    const tbody = document.querySelector(`#${tableId} tbody`);
    tbody.innerHTML = '';
    data.forEach(item => {
        const row = document.createElement('tr');
        fields.forEach(field => {
            const cell = document.createElement('td');
            cell.textContent = item[field];
            row.appendChild(cell);
        });
        const actionCell = document.createElement('td');
        actionCell.className = 'action-buttons';
        actionCell.innerHTML = `
            <button onclick="editItem('${tableId}', ${item.id})">Modifier</button>
            <button onclick="deleteItem('${tableId}', ${item.id})">Supprimer</button>
        `;
        row.appendChild(actionCell);
        tbody.appendChild(row);
    });
}

// Fonction pour gérer la soumission du formulaire
function handleFormSubmit(formId, tableId, dataArray, fields, endpoint) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = parseInt(document.getElementById(`${formId.split('-')[0]}-id`).value);
        const newItem = {};
        fields.forEach(field => {
            const value = document.getElementById(field).value;
            newItem[field] = field.includes('montant') ? parseFloat(value) : (field.includes('id_') ? parseInt(value) : value);
        });

        if (id) {
            // Mise à jour
            const index = dataArray.findIndex(item => item.id === id);
            if (index !== -1) {
                dataArray[index] = { id, ...newItem };
                // TODO: Appeler PUT /endpoint/@id
            }
        } else {
            // Création
            newItem.id = dataArray.length ? Math.max(...dataArray.map(item => item.id)) + 1 : 1;
            dataArray.push(newItem);
            // TODO: Appeler POST /endpoint
        }

        displayData(tableId, dataArray, fields);
        form.reset();
        document.getElementById(`${formId.split('-')[0]}-id`).value = '';
    });
}

// Fonction pour modifier un élément
function editItem(tableId, id) {
    let dataArray, fields;
    if (tableId === 'departement-table') {
        dataArray = departements;
        fields = ['nom', 'description', 'responsable'];
    } else if (tableId === 'etablissement-table') {
        dataArray = etablissements;
        fields = ['nom', 'adresse', 'ville', 'code_postal'];
    } else if (tableId === 'pret-table') {
        dataArray = prets;
        fields = ['id_client', 'id_etab', 'id_pret_type', 'montant', 'date'];
    }

    const item = dataArray.find(item => item.id === id);
    if (item) {
        fields.forEach(field => {
            document.getElementById(field).value = item[field];
        });
        document.getElementById(`${tableId.split('-')[0]}-id`).value = id;
    }
}

// Fonction pour supprimer un élément
function deleteItem(tableId, id) {
    if (tableId === 'departement-table') {
        departements = departements.filter(item => item.id !== id);
        displayData('departement-table', departements, ['id', 'nom', 'description', 'responsable']);
        // TODO: Appeler DELETE /departements/@id
    } else if (tableId === 'etablissement-table') {
        etablissements = etablissements.filter(item => item.id !== id);
        displayData('etablissement-table', etablissements, ['id', 'nom', 'adresse', 'ville', 'code_postal']);
        // TODO: Appeler DELETE /etablissements/@id
    } else if (tableId === 'pret-table') {
        prets = prets.filter(item => item.id !== id);
        displayData('pret-table', prets, ['id', 'id_client', 'id_etab', 'id_pret_type', 'montant', 'date']);
        // TODO: Appeler DELETE /prets/@id
    }
}

// Initialisation des pages
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('departement-table')) {
        displayData('departement-table', departements, ['id', 'nom', 'description', 'responsable']);
        handleFormSubmit('departement-form', 'departement-table', departements, ['nom', 'description', 'responsable'], 'departements');
    } else if (document.getElementById('etablissement-table')) {
        displayData('etablissement-table', etablissements, ['id', 'nom', 'adresse', 'ville', 'code_postal']);
        handleFormSubmit('etablissement-form', 'etablissement-table', etablissements, ['nom', 'adresse', 'ville', 'code_postal'], 'etablissements');
    } else if (document.getElementById('pret-table')) {
        displayData('pret-table', prets, ['id', 'id_client', 'id_etab', 'id_pret_type', 'montant', 'date']);
        handleFormSubmit('pret-form', 'pret-table', prets, ['id_client', 'id_etab', 'id_pret_type', 'montant', 'date'], 'prets');
    }
});