-- Table for Users (general user information)
CREATE TABLE User (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  contact VARCHAR(20),
  email VARCHAR(100) UNIQUE NOT NULL,
  mdp VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Departments
CREATE TABLE Departement (
  id INT AUTO_INCREMENT PRIMARY KEY,
  designation VARCHAR(100) NOT NULL,
  autorise BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Employees
CREATE TABLE Employe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_dept INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES User (id) ON DELETE CASCADE,
  FOREIGN KEY (id_dept) REFERENCES Departement (id) ON DELETE RESTRICT
);

-- Table for Clients
CREATE TABLE Client (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES User (id) ON DELETE CASCADE
);

-- Table for Establishments
CREATE TABLE Etablissement (
  id INT AUTO_INCREMENT PRIMARY KEY,
  designation VARCHAR(100) NOT NULL,
  adresse TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Establishment Funds
CREATE TABLE Etablissement_Fond (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_etab INT NOT NULL,
  montant DECIMAL(15, 2) NOT NULL,
  date DATE NOT NULL,
  libelle TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_etab) REFERENCES Etablissement (id) ON DELETE RESTRICT
);

-- Table for Fund Validation
CREATE TABLE Fond_Validation (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_etab_fond INT NOT NULL,
  statut BOOLEAN DEFAULT FALSE,
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_etab_fond) REFERENCES Etablissement_Fond (id) ON DELETE CASCADE
);

-- Table for Loan Types
CREATE TABLE Pret_Type (
  id INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(50) NOT NULL,
  taux DECIMAL(5, 2) NOT NULL, 
  duree INT NOT NULL, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Client Loans
CREATE TABLE Pret_Client (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_client INT NOT NULL,
  id_etab INT NOT NULL,
  id_pret_type INT NOT NULL,
  montant DECIMAL(15, 2) NOT NULL,
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_client) REFERENCES Client (id) ON DELETE CASCADE,
  FOREIGN KEY (id_etab) REFERENCES Etablissement (id) ON DELETE RESTRICT,
  FOREIGN KEY (id_pret_type) REFERENCES Pret_Type (id) ON DELETE RESTRICT
);

-- Table for Loan Repayments
CREATE TABLE Pret_Retour (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_client_pret INT NOT NULL,
  montant DECIMAL(15, 2) NOT NULL,
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_client_pret) REFERENCES Pret_Client (id) ON DELETE CASCADE
);


ALTER TABLE Employe ADD FOREIGN KEY (id_user) REFERENCES User (id);

ALTER TABLE Employe ADD FOREIGN KEY (id_dept) REFERENCES Departement (id);

ALTER TABLE Client ADD FOREIGN KEY (id_user) REFERENCES User (id);

ALTER TABLE Etablissement_Fond ADD FOREIGN KEY (id_etab) REFERENCES Etablissement (id);

ALTER TABLE Fond_Validation ADD FOREIGN KEY (id_etab_fond) REFERENCES Etablissement_Fond (id);

ALTER TABLE Pret_Client ADD FOREIGN KEY (id_client) REFERENCES Client (id);

ALTER TABLE Pret_Client ADD FOREIGN KEY (id_etab) REFERENCES Etablissement (id);

ALTER TABLE Pret_Client ADD FOREIGN KEY (id_pret_type) REFERENCES Pret_Type (id);

ALTER TABLE Pret_Retour ADD FOREIGN KEY (id_client_pret) REFERENCES Pret_Client (id);


-- Indexes for improved query performance
CREATE INDEX idx_employe_id_user ON Employe (id_user);
CREATE INDEX idx_employe_id_dept ON Employe (id_dept);
CREATE INDEX idx_client_id_user ON Client (id_user);
CREATE INDEX idx_etab_fond_id_etab ON Etablissement_Fond (id_etab);
CREATE INDEX idx_fond_validation_id_etab_fond ON Fond_Validation (id_etab_fond);
CREATE INDEX idx_pret_client_id_client ON Pret_Client (id_client);
CREATE INDEX idx_pret_client_id_etab ON Pret_Client (id_etab);
CREATE INDEX idx_pret_client_id_pret_type ON Pret_Client (id_pret_type);
CREATE INDEX idx_pret_retour_id_client_pret ON Pret_Retour (id_client_pret);
