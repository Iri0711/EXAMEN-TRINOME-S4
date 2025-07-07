<?php
require 'vendor/autoload.php';
require 'db.php';

Flight::set('flight.views.path', __DIR__ . 'views');

Flight::before('start', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
    if (Flight::request()->method === 'OPTIONS') {
        Flight::halt(204);
    }
});

// Format JSON responses with error handling
Flight::map('json', function($data, $code = 200, $options = JSON_UNESCAPED_UNICODE) {
    Flight::response()
        ->status($code)
        ->header('Content-Type', 'application/json')
        ->write(json_encode($data, $options))
        ->send();
});

// Error handling for database operations
Flight::map('error', function(Exception $ex) {
    Flight::json(['error' => $ex->getMessage()], 500);
});

/****************************
 * Routes pour les pages HTML
 ****************************/

Flight::route('GET /', function() {
    try {
        Flight::render('index.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /departements', function() {
    try {
        Flight::render('departements.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /etablissements', function() {
    try {
        Flight::render('etablissements.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /prets', function() {
    try {
        Flight::render('prets.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /users', function() {
    try {
        Flight::render('users.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /clients', function() {
    try {
        Flight::render('clients.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /employees', function() {
    try {
        Flight::render('employees.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /interets', function() {
    try {
        Flight::render('interets.html');
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Départements
 ****************************/

Flight::route('GET /api/departements', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM departements");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/departements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM departements WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Département non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
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
        $stmt = $db->prepare("INSERT INTO departements (designation, autorise) VALUES (?, ?)");
        $stmt->execute([$data->designation, $data->autorise]);
        Flight::json(['message' => 'Département créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
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
        $stmt = $db->prepare("UPDATE departements SET designation = ?, autorise = ? WHERE id = ?");
        $stmt->execute([$data->designation, $data->autorise, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Département mis à jour']);
        } else {
            Flight::json(['error' => 'Département non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/departements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM departements WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Département supprimé']);
        } else {
            Flight::json(['error' => 'Département non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Clients
 ****************************/

Flight::route('GET /api/clients', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM clients");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/clients/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Client non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('POST /api/clients', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO clients (id_user) VALUES (?)");
        $stmt->execute([$data->id_user]);
        Flight::json(['message' => 'Client créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
    }
});
Flight::route('PUT /api/clients/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE clients SET id_user = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Client mis à jour']);
        } else {
            Flight::json(['error' => 'Client non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/clients/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Client supprimé']);
        } else {
            Flight::json(['error' => 'Client non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Employés
 ****************************/

Flight::route('GET /api/employees', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM employes");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/employees/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM employes WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Employé non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('POST /api/employees', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user) || !isset($data->id_departement)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO employes (id_user, id_departement) VALUES (?, ?)");
        $stmt->execute([$data->id_user, $data->id_departement]);
        Flight::json(['message' => 'Employé créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('PUT /api/employees/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_user) || !isset($data->id_departement)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE employes SET id_user = ?, id_departement = ? WHERE id = ?");
        $stmt->execute([$data->id_user, $data->id_departement, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Employé mis à jour']);
        } else {
            Flight::json(['error' => 'Employé non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/employees/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM employes WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Employé supprimé']);
        } else {
            Flight::json(['error' => 'Employé non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Établissements
 ****************************/

Flight::route('GET /api/etablissements', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM etablissements");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/etablissements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM etablissements WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Établissement non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('POST /api/etablissements', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->adresse) || !isset($data->ville) || !isset($data->code_postal)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO etablissements (nom, adresse, ville, code_postal) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->adresse, $data->ville, $data->code_postal]);
        Flight::json(['message' => 'Établissement créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('PUT /api/etablissements/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->adresse) || !isset($data->ville) || !isset($data->code_postal)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE etablissements SET nom = ?, adresse = ?, ville = ?, code_postal = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->adresse, $data->ville, $data->code_postal, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Établissement mis à jour']);
        } else {
            Flight::json(['error' => 'Établissement non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/etablissements/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM etablissements WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Établissement supprimé']);
        } else {
            Flight::json(['error' => 'Établissement non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Intérêts
 ****************************/

Flight::route('GET /api/interets', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM interets");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/interets/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM interets WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Intérêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
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
        $stmt = $db->prepare("INSERT INTO interets (mois, interets, capital_cumule) VALUES (?, ?, ?)");
        $stmt->execute([$data->mois, $data->interets, $data->capital_cumule]);
        Flight::json(['message' => 'Intérêt créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
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
        $stmt = $db->prepare("UPDATE interets SET mois = ?, interets = ?, capital_cumule = ? WHERE id = ?");
        $stmt->execute([$data->mois, $data->interets, $data->capital_cumule, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Intérêt mis à jour']);
        } else {
            Flight::json(['error' => 'Intérêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/interets/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM interets WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Intérêt supprimé']);
        } else {
            Flight::json(['error' => 'Intérêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Utilisateurs
 ****************************/

 Flight::route('GET /api/users', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT id, nom, prenom, contact, email FROM users");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/users/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT id, nom, prenom, contact, email FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Utilisateur non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('POST /api/users', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mot_de_passe)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $hashedPassword = password_hash($data->mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (nom, prenom, contact, email, mot_de_passe) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, $hashedPassword]);
        Flight::json(['message' => 'Utilisateur créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('PUT /api/users/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->nom) || !isset($data->prenom) || !isset($data->contact) || !isset($data->email) || !isset($data->mot_de_passe)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $hashedPassword = password_hash($data->mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET nom = ?, prenom = ?, contact = ?, email = ?, mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->prenom, $data->contact, $data->email, $hashedPassword, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Utilisateur mis à jour']);
        } else {
            Flight::json(['error' => 'Utilisateur non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/users/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Utilisateur supprimé']);
        } else {
            Flight::json(['error' => 'Utilisateur non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

/****************************
 * API Routes pour Prêts
 ****************************/

Flight::route('GET /api/prets', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM prets");
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('GET /api/prets/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM prets WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            Flight::json($result);
        } else {
            Flight::json(['error' => 'Prêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('POST /api/prets', function() {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_client) || !isset($data->id_etablissement) || !isset($data->id_type_pret) || !isset($data->montant) || !isset($data->date)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO prets (id_client, id_etablissement, id_type_pret, montant, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->id_client, $data->id_etablissement, $data->id_type_pret, $data->montant, $data->date]);
        Flight::json(['message' => 'Prêt créé', 'id' => $db->lastInsertId()], 201);
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('PUT /api/prets/@id', function($id) {
    try {
        $data = Flight::request()->data;
        if (!isset($data->id_client) || !isset($data->id_etablissement) || !isset($data->id_type_pret) || !isset($data->montant) || !isset($data->date)) {
            Flight::json(['error' => 'Données incomplètes'], 400);
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE prets SET id_client = ?, id_etablissement = ?, id_type_pret = ?, montant = ?, date = ? WHERE id = ?");
        $stmt->execute([$data->id_client, $data->id_etablissement, $data->id_type_pret, $data->montant, $data->date, $id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Prêt mis à jour']);
        } else {
            Flight::json(['error' => 'Prêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::route('DELETE /api/prets/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM prets WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            Flight::json(['message' => 'Prêt supprimé']);
        } else {
            Flight::json(['error' => 'Prêt non trouvé'], 404);
        }
    } catch (Exception $e) {
        Flight::error($e);
    }
});

Flight::start();
?>