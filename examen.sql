CREATE TABLE Employes(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    role TEXT NOT NULL,
    departement TEXT NOT NULL,
    date_embauche DATE NOT NULL,
    actif INTEGER DEFAULT 0
);


CREATE TABLE Departements(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE Types_conges(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jours_annuels INTEGER NOT NULL,
    deductible INTEGER DEFAULT 0
);

CREATE TABLE Soldes(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    annee INTEGER NOT NULL,
    jours_attribues INTEGER NOT NULL,
    jours_pris INTEGER NOT NULL,
    FOREIGN KEY (employe_id) REFERENCES Employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES Types_conges(id)
);

CREATE TABLE Conges(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours INTEGER NOT NULL,
    motif TEXT NOT NULL,
    statut TEXT NOT NULL,
    commentaire_rh TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER NOT NULL,
    FOREIGN KEY (employe_id) REFERENCES Employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES Types_conges(id),
    FOREIGN KEY (traite_par) REFERENCES Employes(id)
);