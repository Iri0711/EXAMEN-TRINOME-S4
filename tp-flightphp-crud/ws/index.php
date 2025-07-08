<?php
require 'vendor/autoload.php';
require_once 'db.php';

// Route pour la page d'accueil
Flight::route('GET /', function() {
    Flight::render('index.php');
});

// Routes pour les vues
Flight::route('GET /departements', function() {
    Flight::render('departements.php');
});

Flight::route('GET /etablissements', function() {
    Flight::render('etablissements.php');
});

Flight::route('GET /prets', function() {
    Flight::render('prets.php');
});

Flight::route('GET /users', function() {
    Flight::render('users.php');
});

Flight::route('GET /clients', function() {
    Flight::render('clients.php');
});

Flight::route('GET /employees', function() {
    Flight::render('employees.php');
});

Flight::route('GET /interets', function() {
    Flight::render('interets.php');
});

// Routes API pour les départements
Flight::route('GET /api/departements', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM departement");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/departements', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->designation) || !isset($data->autorise)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO departement (designation, autorise) VALUES (?, ?)");
        $stmt->execute([$data->designation, $data->autorise]);
        Flight::json(['message' => 'Département créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/departements/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->designation) || !isset($data->autorise)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE departement SET designation = ?, autorise = ? WHERE id = ?");
        $stmt->execute([$data->designation, $data->autorise, $id]);
        Flight::json(['message' => 'Département mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/departements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM departement WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Département supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Routes API pour les établissements
Flight::route('GET /api/etablissements', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Etablissement");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/etablissements', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->designation) || !isset($data->adresse)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Etablissement (designation, adresse) VALUES (?, ?)");
        $stmt->execute([$data->designation, $data->adresse]);
        Flight::json(['message' => 'Établissement créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/etablissements/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->designation) || !isset($data->adresse)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE Etablissement SET designation = ?, adresse = ? WHERE id = ?");
        $stmt->execute([$data->designation, $data->adresse, $id]);
        Flight::json(['message' => 'Établissement mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/etablissements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Etablissement WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Établissement supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Routes API pour les prêts
Flight::route('GET /api/pret_types', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Pret_Type");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/pret_types', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->libelle) || !isset($data->taux) || !isset($data->duree)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Pret_Type (libelle, taux, duree) VALUES (?, ?, ?)");
        $stmt->execute([$data->libelle, $data->taux, $data->duree]);
        Flight::json(['message' => 'Type de prêt créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/pret_types/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->libelle) || !isset($data->taux) || !isset($data->duree)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE Pret_Type SET libelle = ?, taux = ?, duree = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->taux, $data->duree, $id]);
        Flight::json(['message' => 'Type de prêt mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/pret_types/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Pret_Type WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Type de prêt supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Route pour la page Type_Pret.php
Flight::route('GET /type_prets', function() {
    Flight::render('Type_Pret.php');
});

// Routes API pour les utilisateurs
Flight::route('GET /api/users', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM User");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/users', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mdp)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO User (nom, prenom, contact, email, mdp) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, password_hash($data->mdp, PASSWORD_BCRYPT)]);
        Flight::json(['message' => 'Utilisateur créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/users/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mdp)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE User SET nom = ?, prenom = ?, contact = ?, email = ?, mdp = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, password_hash($data->mdp, PASSWORD_BCRYPT), $id]);
        Flight::json(['message' => 'Utilisateur mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/users/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM User WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Utilisateur supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Routes API pour les clients
Flight::route('GET /clients', function() {
    Flight::render('clients.php');
});

// Routes API pour les clients
Flight::route('GET /api/clients', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Client");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/clients', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user)) {
            Flight::json(['error' => 'ID utilisateur manquant'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Client (id_user) VALUES (?)");
        $stmt->execute([$data->id_user]);
        Flight::json(['message' => 'Client créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/clients/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user)) {
            Flight::json(['error' => 'ID utilisateur manquant'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE Client SET id_user = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $id]);
        Flight::json(['message' => 'Client mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/clients/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Client WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Client supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Route pour la page employees
// Routes API pour les employés
Flight::route('GET /api/employees', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Employe");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/employees', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user) || !isset($data->id_dept)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        $db = getDB();
        
        // Vérifier si l'utilisateur existe
        $stmt = $db->prepare("SELECT id FROM User WHERE id = ?");
        $stmt->execute([$data->id_user]);
        if (!$stmt->fetch()) {
            Flight::json(['error' => "L'utilisateur spécifié n'existe pas"], 400);
            return;
        }

        // Créer l'employé
        $stmt = $db->prepare("INSERT INTO Employe (id_user, id_dept) VALUES (?, ?)");
        $stmt->execute([$data->id_user, $data->id_dept]);
        Flight::json(['message' => 'Employé créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/employees/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user) || !isset($data->id_dept)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }

        $db = getDB();
        
        // Vérifier si l'employé existe
        $stmt = $db->prepare("SELECT id FROM Employe WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            Flight::json(['error' => "Employé non trouvé"], 404);
            return;
        }

        // Mettre à jour l'employé
        $stmt = $db->prepare("UPDATE Employe SET id_user = ?, id_dept = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $data->id_dept, $id]);
        Flight::json(['message' => 'Employé mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/employees/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Employe WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Employé supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Routes API pour les intérêts
Flight::route('GET /api/interets', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM interet");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/interets', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->mois) || !isset($data->interets) || !isset($data->capital_cumule)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO interet (mois, interets, capital_cumule) VALUES (?, ?, ?)");
        $stmt->execute([$data->mois, $data->interets, $data->capital_cumule]);
        Flight::json(['message' => 'Intérêt créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /api/interets/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->mois) || !isset($data->interets) || !isset($data->capital_cumule)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE interet SET mois = ?, interets = ?, capital_cumule = ? WHERE id = ?");
        $stmt->execute([$data->mois, $data->interets, $data->capital_cumule, $id]);
        Flight::json(['message' => 'Intérêt mis à jour']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/interets/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM interet WHERE id = ?");
        $stmt->execute([$id]);
        Flight::json(['message' => 'Intérêt supprimé']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

// Gestion des erreurs globales
Flight::map('error', function(Exception $e) {
    Flight::json(['error' => $e->getMessage()], 500);
});

Flight::start();
?>