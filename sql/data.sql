-- Populate User (Admin)
INSERT INTO User (nom, prenom, contact, email, mdp) 
VALUES ('Dupont', 'Jean', '+1234567890', 'admin@finance.com', 'Admin123'); -- Password: Admin123

-- Populate Department
INSERT INTO Departement (designation, autorise) 
VALUES ('Administration', TRUE);

-- Populate Employee (Admin linked to Department)
INSERT INTO Employe (id_user, id_dept) 
VALUES (1, 1);

-- Populate Establishment
INSERT INTO Etablissement (designation, adresse) 
VALUES ('Banque Centrale', '123 Rue de la Finance, Paris');

-- Populate Establishment Fund
INSERT INTO Etablissement_Fond (id_etab, montant, date, libelle) 
VALUES (1, 1000000.00, '2025-07-01', 'Fonds initial');

-- Populate Fund Validation
INSERT INTO Fond_Validation (id_etab_fond, statut, date) 
VALUES (1, TRUE, '2025-07-02');

-- Populate Client
INSERT INTO Client (id_user) 
VALUES (1); -- Admin is also a client for simplicity in testing

-- Populate Loan Type
INSERT INTO Pret_Type (libelle, taux, duree) 
VALUES ('Prêt Personnel', 5.50, 36);

-- Populate Client Loan
INSERT INTO Pret_Client (id_client, id_etab, id_pret_type, montant, date) 
VALUES (1, 1, 1, 50000.00, '2025-07-03');

-- Populate Loan Repayment
INSERT INTO Pret_Retour (id_client_pret, montant, date) 
VALUES (1, 1000.00, '2025-07-05');