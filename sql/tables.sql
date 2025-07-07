-- Table User
CREATE TABLE `User` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(255) NOT NULL,
  `prenom` VARCHAR(255) NOT NULL,
  `contact` VARCHAR(255),
  `email` VARCHAR(255) UNIQUE,
  `mdp` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Table Departement
CREATE TABLE `Departement` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `designation` VARCHAR(255) NOT NULL,
  `autorise` TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;

-- Table Employe
CREATE TABLE `Employe` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `id_dept` INT NOT NULL,
  FOREIGN KEY (`id_user`) REFERENCES `User` (`id`),
  FOREIGN KEY (`id_dept`) REFERENCES `Departement` (`id`)
) ENGINE=InnoDB;

-- Table Client
CREATE TABLE `Client` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  FOREIGN KEY (`id_user`) REFERENCES `User` (`id`)
) ENGINE=InnoDB;

-- Table Etablissement
CREATE TABLE `Etablissement` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `designation` VARCHAR(255) NOT NULL,
  `adresse` TEXT
) ENGINE=InnoDB;

-- Table Etablissement_Fond
CREATE TABLE `Etablissement_Fond` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_etab` INT NOT NULL,
  `montant` DECIMAL(10,2) NOT NULL,
  `date` DATE NOT NULL,
  `libelle` TEXT,
  FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`)
) ENGINE=InnoDB;

-- Table Fond_Validation
CREATE TABLE `Fond_Validation` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_etab_fond` INT NOT NULL,
  `statut` TINYINT(1) DEFAULT 0,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_etab_fond`) REFERENCES `Etablissement_Fond` (`id`)
) ENGINE=InnoDB;

-- Table Pret_Type
CREATE TABLE `Pret_Type` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `libelle` VARCHAR(255) NOT NULL,
  `taux` DECIMAL(5,2) NOT NULL,
  `duree` INT NOT NULL
) ENGINE=InnoDB;

-- Table Pret_Client
CREATE TABLE `Pret_Client` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_client` INT NOT NULL,
  `id_etab` INT NOT NULL,
  `id_pret_type` INT NOT NULL,
  `montant` DECIMAL(10,2) NOT NULL,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_client`) REFERENCES `Client` (`id`),
  FOREIGN KEY (`id_etab`) REFERENCES `Etablissement` (`id`),
  FOREIGN KEY (`id_pret_type`) REFERENCES `Pret_Type` (`id`)
) ENGINE=InnoDB;

-- Table Pret_Retour
CREATE TABLE `Pret_Retour` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_client_pret` INT NOT NULL,
  `montant` DECIMAL(10,2) NOT NULL,
  `date` DATE NOT NULL,
  FOREIGN KEY (`id_client_pret`) REFERENCES `Pret_Client` (`id`)
) ENGINE=InnoDB;