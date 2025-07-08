<?php
require 'vendor/autoload.php';
require 'db.php';
// Load all route files
$routesDir = 'routes';
foreach (glob("$routesDir/*.php") as $routeFile) {
    require $routeFile;
}


Flight::route('GET /', function() {
    readfile('../index.html');
});

// Enable CORS for development
Flight::before('start', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
    if (Flight::request()->method === 'OPTIONS') {
        Flight::halt(204);
    }
});

// Format JSON responses
Flight::map('json', function($data, $code = 200, $options = JSON_UNESCAPED_UNICODE) {
    Flight::response()
        ->status($code)
        ->header('Content-Type', 'application/json')
        ->write(json_encode($data, $options))
        ->send();
});

// Admin Login
Flight::route('POST /ws/login', function() {
    $request = Flight::request()->data;
    $email = $request->email;
    $password = $request->password;

    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mdp'])) {
        $stmt = $db->prepare("SELECT * FROM Employe WHERE id_user = ?");
        $stmt->execute([$user['id']]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($employee) {
            Flight::json(['success' => true, 'user' => $user]);
        } else {
            Flight::json(['success' => false, 'message' => 'Not an employee']);
        }
    } else {
        Flight::json(['success' => false, 'message' => 'Invalid credentials']);
    }
});

// Financial Establishment Funds
Flight::route('GET /ws/funds', function() {
    $db = getDB();

    $stmt = $db->query("SELECT ef.*, e.designation FROM Etablissement_Fond ef JOIN Etablissement e ON ef.id_etab = e.id");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('POST /ws/funds', function() {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Etablissement_Fond (id_etab, montant, date, libelle) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data->id_etab, $data->montant, $data->date, $data->libelle]);
    Flight::json(['message' => 'Fund added', 'id' => $db->lastInsertId()]);
});

Flight::route('PUT /ws/funds/@id', function($id) {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("UPDATE Etablissement_Fond SET id_etab = ?, montant = ?, date = ?, libelle = ? WHERE id = ?");
    $stmt->execute([$data->id_etab, $data->montant, $data->date, $data->libelle, $id]);
    Flight::json(['message' => 'Fund updated']);
});

Flight::route('DELETE /ws/funds/@id', function($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM Etablissement_Fond WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Fund deleted']);
});

// Fund Validations
Flight::route('GET /ws/validations', function() {
    $db = getDB();
    $stmt = $db->query("SELECT fv.*, ef.libelle FROM Fond_Validation fv JOIN Etablissement_Fond ef ON fv.id_etab_fond = ef.id");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('POST /ws/validations', function() {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Fond_Validation (id_etab_fond, statut, date) VALUES (?, ?, ?)");
    $stmt->execute([$data->id_etab_fond, $data->statut, $data->date]);
    Flight::json(['message' => 'Validation added', 'id' => $db->lastInsertId()]);
});

Flight::route('PUT /ws/validations/@id', function($id) {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("UPDATE Fond_Validation SET id_etab_fond = ?, statut = ?, date = ? WHERE id = ?");
    $stmt->execute([$data->id_etab_fond, $data->statut, $data->date, $id]);
    Flight::json(['message' => 'Validation updated']);
});

Flight::route('DELETE /ws/validations/@id', function($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM Fond_Validation WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Validation deleted']);
});

// Loan Types
Flight::route('GET /ws/loan-types', function() {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM Pret_Type");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('POST /ws/loan-types', function() {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Pret_Type (libelle, taux, duree) VALUES (?, ?, ?)");
    $stmt->execute([$data->libelle, $data->taux, $data->duree]);
    Flight::json(['message' => 'Loan type added', 'id' => $db->lastInsertId()]);
});

Flight::route('PUT /ws/loan-types/@id', function($id) {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("UPDATE Pret_Type SET libelle = ?, taux = ?, duree = ? WHERE id = ?");
    $stmt->execute([$data->libelle, $data->taux, $data->duree, $id]);
    Flight::json(['message' => 'Loan type updated']);
});

Flight::route('DELETE /ws/loan-types/@id', function($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM Pret_Type WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Loan type deleted']);
});

// Client Loans
Flight::route('GET /ws/client-loans', function() {
    $db = getDB();
    $stmt = $db->query("SELECT pc.*, c.id_user, e.designation, pt.libelle 
                        FROM Pret_Client pc 
                        JOIN Client c ON pc.id_client = c.id 
                        JOIN Etablissement e ON pc.id_etab = e.id 
                        JOIN Pret_Type pt ON pc.id_pret_type = pt.id");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('POST /ws/client-loans', function() {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Pret_Client (id_client, id_etab, id_pret_type, montant, date) 
                         VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data->id_client, $data->id_etab, $data->id_pret_type, $data->montant, $data->date]);
    Flight::json(['message' => 'Client loan added', 'id' => $db->lastInsertId()]);
});

Flight::route('PUT /ws/client-loans/@id', function($id) {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("UPDATE Pret_Client SET id_client = ?, id_etab = ?, id_pret_type = ?, montant = ?, date = ? 
                         WHERE id = ?");
    $stmt->execute([$data->id_client, $data->id_etab, $data->id_pret_type, $data->montant, $data->date, $id]);
    Flight::json(['message' => 'Client loan updated']);
});

Flight::route('DELETE /ws/client-loans/@id', function($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM Pret_Client WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Client loan deleted']);
});

// Loan Repayments
Flight::route('GET /ws/repayments', function() {
    $db = getDB();
    $stmt = $db->query("SELECT pr.*, pc.montant AS loan_amount 
                        FROM Pret_Retour pr 
                        JOIN Pret_Client pc ON pr.id_client_pret = pc.id");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('POST /ws/repayments', function() {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Pret_Retour (id_client_pret, montant, date) VALUES (?, ?, ?)");
    $stmt->execute([$data->id_client_pret, $data->montant, $data->date]);
    Flight::json(['message' => 'Repayment added', 'id' => $db->lastInsertId()]);
});

Flight::route('PUT /ws/repayments/@id', function($id) {
    $data = Flight::request()->data;
    $db = getDB();
    $stmt = $db->prepare("UPDATE Pret_Retour SET id_client_pret = ?, montant = ?, date = ? WHERE id = ?");
    $stmt->execute([$data->id_client_pret, $data->montant, $data->date, $id]);
    Flight::json(['message' => 'Repayment updated']);
});

Flight::route('DELETE /ws/repayments/@id', function($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM Pret_Retour WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Repayment deleted']);
});

Flight::start();
?>