CREATE TABLE `User` (
  `id` integer,
  `nom` text,
  `prenom` text,
  `contact` text,
  `email` text,
  `mdp` text
);

CREATE TABLE `Departement` (
  `id` integer,
  `designation` text,
  `autorise` boolean
);

CREATE TABLE `Employe` (
  `id` integer,
  `id_user` integer,
  `id_dept` integer
);

CREATE TABLE `Client` (
  `id` integer,
  `id_user` integer
);

CREATE TABLE `Etablissement` (
  `id` integer,
  `designation` text,
  `adresse` text
);

CREATE TABLE `Etablissement_Fond` (
  `id` integer,
  `id_etab` integer,
  `montant` decimal,
  `date` date,
  `libelle` text
);

CREATE TABLE `Fond_Validation` (
  `id` integer,
  `id_etab_fond` integer,
  `statut` boolean,
  `date` date
);

CREATE TABLE `Pret_Retour` (
  `id` integer,
  `id_client_pret` integer,
  `montant` decimal,
  `date` date
);

CREATE TABLE `Pret_Type` (
  `id` integer,
  `libelle` integer,
  `taux` decimal,
  `duree` integer
);

CREATE TABLE `Pret_Client` (
  `id` integer,
  `id_client` integer,
  `id_etab` integer,
  `id_pret_type` integer,
  `montant` decimal,
  `date` date
);

ALTER TABLE `Employe` ADD FOREIGN KEY (`id_user`) REFERENCES `User` (`id`);

ALTER TABLE `Employe` ADD FOREIGN KEY (`id_dept`) REFERENCES `Departement` (`id`);

ALTER TABLE `Client` ADD FOREIGN KEY (`id_user`) REFERENCES `User` (`id`);

ALTER TABLE `Etablissement_Fond` ADD FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`);

ALTER TABLE `Fond_Validation` ADD FOREIGN KEY (`id_etab_fond`) REFERENCES `Etablissement_Fond` (`id`);

ALTER TABLE `Pret_Client` ADD FOREIGN KEY (`id_client`) REFERENCES `Client` (`id`);

ALTER TABLE `Pret_Client` ADD FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`);

ALTER TABLE `Pret_Client` ADD FOREIGN KEY (`id_pret_type`) REFERENCES `Pret_Type` (`id`);

ALTER TABLE `Pret_Retour` ADD FOREIGN KEY (`id_client_pret`) REFERENCES `Pret_Client` (`id`);
