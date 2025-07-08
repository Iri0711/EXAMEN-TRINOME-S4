-- Insertion dans la table User
INSERT INTO `User` (`nom`, `prenom`, `contact`, `email`, `mdp`) VALUES
('Dupont', 'Jean', '0123456789', 'jean.dupont@example.com', 'hashed_password1'),
('Martin', 'Sophie', '0987654321', 'sophie.martin@example.com', 'hashed_password2'),
('Durand', 'Paul', '0678901234', 'paul.durand@example.com', 'hashed_password3'),
('Lefevre', 'Marie', '0543219876', 'marie.lefevre@example.com', 'hashed_password4');

-- Insertion dans la table Departement (seulement Finance et Admin)
INSERT INTO `Departement` (`designation`, `autorise`) VALUES
('Finance', FALSE),
('Admin', TRUE);

-- Insertion dans la table Employe
INSERT INTO `Employe` (`id_user`, `id_dept`) VALUES
(1, 1), -- Jean Dupont dans Finance
(2, 2); -- Sophie Martin dans Admin

-- Insertion dans la table Client
INSERT INTO `Client` (`id_user`) VALUES
(3), -- Paul Durand comme client
(4); -- Marie Lefevre comme client

-- Insertion dans la table Etablissement
INSERT INTO `Etablissement` (`designation`, `adresse`) VALUES
('Agence Paris', '12 Rue de la Paix, 75001 Paris'),
('Agence Lyon', '45 Avenue Foch, 69006 Lyon');

-- Insertion dans la table Etablissement_Fond
INSERT INTO `Etablissement_Fond` (`id_etab`, `montant`, `date`, `libelle`) VALUES
(1, 100000.00, '2025-01-15', 'Fonds initial Paris'),
(1, 50000.00, '2025-02-01', 'Fonds supplémentaire Paris'),
(2, 75000.00, '2025-03-10', 'Fonds initial Lyon');

-- Insertion dans la table Fond_Validation
INSERT INTO `Fond_Validation` (`id_etab_fond`, `statut`, `date`) VALUES
(1, TRUE, '2025-01-16'), -- Fonds initial Paris validé
(2, FALSE, '2025-02-02'), -- Fonds supplémentaire Paris non validé
(3, TRUE, '2025-03-11'); -- Fonds initial Lyon validé

-- Insertion dans la table Pret_Type
INSERT INTO `Pret_Type` (`libelle`, `taux`, `duree`) VALUES
('Prêt Immobilier', 2.50, 240), -- 20 ans
('Prêt Consommation', 5.00, 60), -- 5 ans
('Prêt Auto', 3.75, 48); -- 4 ans

-- Insertion dans la table Pret_Client
INSERT INTO `Pret_Client` (`id_client`, `id_etab`, `id_pret_type`, `montant`, `date`) VALUES
(1, 1, 1, 200000.00, '2025-04-01'), -- Paul Durand, prêt immobilier à Paris
(2, 1, 2, 15000.00, '2025-05-15'), -- Marie Lefevre, prêt consommation à Lyon
(1, 1, 3, 25000.00, '2025-06-10'); -- Paul Durand, prêt auto à Paris

-- Insertion dans la table Pret_Retour
INSERT INTO `Pret_Retour` (`id_client_pret`, `montant`, `date`) VALUES
(1, 1000.00, '2025-05-01'), -- Remboursement partiel du prêt immobilier de Paul
(2, 500.00, '2025-06-01'), -- Remboursement partiel du prêt consommation de Marie
(3, 600.00, '2025-07-01'); -- Remboursement partiel du prêt auto de Paul
 -- Remboursement partiel du prêt immobilier de Paul

INSERT INTO `Pret_Retour` (`id_client_pret`, `montant`, `date`) VALUES (1, 1000.00, '2025-07-01');