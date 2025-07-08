INSERT INTO `User` (`id`, `nom`, `prenom`, `contact`, `email`, `mdp`) VALUES
(1, 'Dupont', 'Jean', '0123456789', 'jean.dupont@email.com', 'motdepasse1'),
(2, 'Martin', 'Sophie', '0234567891', 'sophie.martin@email.com', 'motdepasse2'),
(3, 'Bernard', 'Pierre', '0345678912', 'pierre.bernard@email.com', 'motdepasse3'),
(4, 'Petit', 'Marie', '0456789123', 'marie.petit@email.com', 'motdepasse4'),
(5, 'Durand', 'Luc', '0567891234', 'luc.durand@email.com', 'motdepasse5');

INSERT INTO `Departement` (`id`, `designation`, `autorise`) VALUES
(1, 'Comptabilité', 1),
(2, 'Ressources Humaines', 1),
(3, 'Direction', 1),
(4, 'Service Client', 1),
(5, 'Validation Prêts', 1);

INSERT INTO `Employe` (`id`, `id_user`, `id_dept`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);


INSERT INTO `Client` (`id`, `id_user`) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO `Etablissement` (`id`, `designation`, `adresse`) VALUES
(1, 'Agence Principale', '123 Rue de la Finance, 75001 Paris');


INSERT INTO `Etablissement_Fond` (`id`, `id_etab`, `montant`, `date`, `libelle`) VALUES
(1, 1, 100000.00, '2023-01-15', 'Fond initial'),
(2, 1, 50000.00, '2023-02-20', 'Approvisionnement trimestriel'),
(3, 1, 75000.00, '2023-03-10', 'Approvisionnement exceptionnel');

INSERT INTO `Fond_Validation` (`id`, `id_etab_fond`, `statut`, `date`) VALUES
(1, 1, 1, '2023-01-16'),
(2, 2, 1, '2023-02-21'),
(3, 3, 0, '2023-03-11');

INSERT INTO `Pret_Type` (`id`, `libelle`, `taux`, `duree`) VALUES
(1, 'Prêt personnel', 3.5, 60),
(2, 'Prêt immobilier', 2.5, 240),
(3, 'Prêt automobile', 4.0, 48);

INSERT INTO `Pret_Client` (`id`, `id_client`, `id_etab`, `id_pret_type`, `montant`, `date`) VALUES
(1, 1, 1, 1, 10000.00, '2023-01-20'),
(2, 2, 1, 2, 200000.00, '2023-02-15'),
(3, 3, 1, 3, 25000.00, '2023-03-05');

INSERT INTO `Pret_Retour` (`id`, `id_client_pret`, `montant`, `date`) VALUES
(1, 1, 500.00, '2023-02-20'),
(2, 1, 500.00, '2023-03-20'),
(3, 2, 1000.00, '2023-03-15'),
(4, 3, 600.00, '2023-04-05');

INSERT INTO `Pret_Assurance` (`id`, `id_client_pret`, `montant`, `description`) VALUES
(1, 1, 200.00, 'Assurance décès-invalidité'),
(2, 2, 500.00, 'Assurance habitation'),
(3, 3, 300.00, 'Assurance automobile');