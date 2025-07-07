DROP DATABASE IF EXISTS banque;
CREATE DATABASE banque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE banque;

CREATE TABLE `User` (
  `id` INT PRIMARY KEY,
  `nom` TEXT NOT NULL,
  `prenom` TEXT NOT NULL,
  `contact` TEXT,
  `email` TEXT NOT NULL,
  `mdp` TEXT NOT NULL
);

CREATE TABLE `Departement` (
  `id` INT PRIMARY KEY,
  `designation` TEXT NOT NULL,
  `autorise` BOOLEAN NOT NULL
);

CREATE TABLE `Employe` (
  `id` INT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `id_dept` INT NOT NULL,
  FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_dept`) REFERENCES `Departement` (`id`) ON DELETE CASCADE
);

CREATE TABLE `Client` (
  `id` INT PRIMARY KEY,
  `id_user` INT NOT NULL,
  FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE
);

CREATE TABLE `Etablissement` (
  `id` INT PRIMARY KEY,
  `designation` TEXT NOT NULL,
  `adresse` TEXT NOT NULL
);

CREATE TABLE `Etablissement_Fond` (
  `id` INT PRIMARY KEY,
  `id_etab` INT NOT NULL,
  `montant` DECIMAL(15,2) NOT NULL,
  `date` DATE NOT NULL,
  `libelle` TEXT,
  FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`) ON DELETE CASCADE
);

CREATE TABLE `Fond_Validation` (
  `id` INT PRIMARY KEY,
  `id_etab_fond` INT NOT NULL,
  `statut` BOOLEAN NOT NULL,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_etab_fond`) REFERENCES `Etablissement_Fond` (`id`) ON DELETE CASCADE
);

CREATE TABLE `Pret_Type` (
  `id` INT PRIMARY KEY,
  `libelle` TEXT NOT NULL,
  `taux` DECIMAL(5,2) NOT NULL,
  `duree` INT NOT NULL
);

CREATE TABLE `Pret_Client` (
  `id` INT PRIMARY KEY,
  `id_client` INT NOT NULL,
  `id_etab` INT NOT NULL,
  `id_pret_type` INT NOT NULL,
  `montant` DECIMAL(15,2) NOT NULL,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_client`) REFERENCES `Client` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_pret_type`) REFERENCES `Pret_Type` (`id`) ON DELETE CASCADE
);

CREATE TABLE `Pret_Retour` (
  `id` INT PRIMARY KEY,
  `id_client_pret` INT NOT NULL,
  `montant` DECIMAL(15,2) NOT NULL,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_client_pret`) REFERENCES `Pret_Client` (`id`) ON DELETE CASCADE
);