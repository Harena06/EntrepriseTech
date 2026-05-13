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


INSERT INTO Departements (nom, description) VALUES
('Informatique', 'Gestion des systèmes informatiques et développement'),
('Ressources Humaines', 'Gestion des employés et des recrutements'),
('Finance', 'Gestion financière et comptable'),
('Marketing', 'Communication et promotion'),
('Direction', 'Administration générale de l’entreprise');


INSERT INTO Types_conges (libelle, jours_annuels, deductible) VALUES
('Congé annuel', 30, 1),
('Congé maladie', 15, 0),
('Congé maternité', 90, 0),
('Permission exceptionnelle', 5, 1);


INSERT INTO Employes (
    nom,
    email,
    mot_de_passe,
    role,
    departement,
    date_embauche,
    actif
) VALUES
(
    'Jean Rakoto',
    'jean@entreprise.com',
    'password123',
    'employe',
    'Informatique',
    '2023-01-15',
    1
),
(
    'Sarah Rabenja',
    'sarah@entreprise.com',
    'password123',
    'employe',
    'Finance',
    '2022-08-10',
    1
),
(
    'Mickael Andriamanitra',
    'mickael@entreprise.com',
    'rh123',
    'rh',
    'Ressources Humaines',
    '2021-03-05',
    1
),
(
    'Admin System',
    'admin@entreprise.com',
    'admin123',
    'admin',
    'Direction',
    '2020-01-01',
    1
),
(
    'Lucie Randria',
    'lucie@entreprise.com',
    'password123',
    'employe',
    'Marketing',
    '2024-02-20',
    1
);



INSERT INTO Soldes (
    employe_id,
    type_conge_id,
    annee,
    jours_attribues,
    jours_pris
) VALUES

-- Jean
(1, 1, 2026, 30, 5),
(1, 2, 2026, 15, 2),
(1, 4, 2026, 5, 1),

-- Sarah
(2, 1, 2026, 30, 10),
(2, 2, 2026, 15, 0),
(2, 4, 2026, 5, 2),

-- Mickael RH
(3, 1, 2026, 30, 4),
(3, 2, 2026, 15, 1),

-- Admin
(4, 1, 2026, 30, 0),

-- Lucie
(5, 1, 2026, 30, 3),
(5, 2, 2026, 15, 0);


INSERT INTO Conges (
    employe_id,
    type_conge_id,
    date_debut,
    date_fin,
    nb_jours,
    motif,
    statut,
    commentaire_rh,
    traite_par
) VALUES

(
    1,
    1,
    '2026-05-20',
    '2026-05-24',
    5,
    'Vacances en famille',
    'approuve',
    'Demande validée',
    3
),

(
    2,
    2,
    '2026-04-10',
    '2026-04-11',
    2,
    'Consultation médicale',
    'approuve',
    'Justificatif reçu',
    3
),

(
    5,
    4,
    '2026-06-02',
    '2026-06-02',
    1,
    'Événement familial',
    'en_attente',
    '',
    3
),

(
    1,
    1,
    '2026-07-01',
    '2026-07-03',
    3,
    'Repos personnel',
    'refuse',
    'Période de forte activité',
    3
);