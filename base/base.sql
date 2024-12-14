-- Création de la table `bien`
CREATE TABLE bien (
    id SERIAL NOT NULL PRIMARY KEY,
    type_id INT NOT NULL,
    proprietaire_id INT NOT NULL,
    region_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    loyer NUMERIC(15, 2) NOT NULL,
    photos VARCHAR(255) NOT NULL
);

-- Création de la table `location`
CREATE TABLE location (
    id SERIAL NOT NULL PRIMARY KEY,
    client_id INT NOT NULL,
    duree INT NOT NULL,
    date_debut DATE NOT NULL
);

-- Création de la table `region`
CREATE TABLE region (
    id SERIAL NOT NULL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Création de la table `type_bien`
CREATE TABLE type_bien (
    id SERIAL NOT NULL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    commission NUMERIC(4, 2) NOT NULL
);

-- Création de la table `type_utilisateur`
CREATE TABLE type_utilisateur (
    id SERIAL NOT NULL PRIMARY KEY,
    libele VARCHAR(255) NOT NULL
);

-- Création de la table `utilisateur`
CREATE TABLE utilisateur (
    id SERIAL NOT NULL PRIMARY KEY,
    type_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) DEFAULT NULL,
    pseudo VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);



CREATE TABLE refresh_token (
    id SERIAL PRIMARY KEY,
    utilisateur_id INT NOT NULL,  -- Référence à l'utilisateur
    token VARCHAR(255) NOT NULL,  -- Le Refresh Token
    expire_at TIMESTAMP NOT NULL, -- Date d'expiration du token
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);



-- Insertion des types d'utilisateurs
INSERT INTO type_utilisateur (id, libele)
VALUES 
    (1, 'Admin'),
    (2, 'Propriétaire'),
    (3, 'Client');


-- Insertion des utilisateurs
INSERT INTO utilisateur (id, type_id, nom, prenom, pseudo, mdp, telephone, email)
VALUES 
    (1, 1, 'Dupont', 'Alice', 'aliceDupont', 'admin123', '0102030405', 'alice@admin.com'),  -- Admin
    (2, 2, 'Lemoine', 'Paul', 'paulLemoine', 'prop123', '0102030607', 'paul@prop.com'),   -- Propriétaire
    (3, 3, 'Martin', 'Claire', 'claireMartin', 'client123', '0102030809', 'claire@client.com'),  -- Client
    -- -------------------------------------------------------- -- --------------------------------
    (4,2, 'Andrianina', 'Mickael', 'mickaelAndri', 'prop123', '0341234567', 'mickael@prop.com'),
    (5,2, 'Rasolofoniaina', 'Cynthia', 'cynthiaRasolo', 'prop123', '0347654321', 'cynthia@prop.com'),
    (6,2, 'Rajaonarivo', 'Jean', 'jeanRajaona', 'prop123', '0349876543', 'jean@prop.com'),
    (7,2, 'Rakotoarisoa', 'Pauline', 'paulineRakoto', 'prop123', '0345678901', 'pauline@prop.com'),
    (8,2, 'Razafindrasoa', 'Patrick', 'patrickRazafy', 'prop123', '0346789012', 'patrick@prop.com'),
    (9,2, 'Ravelomanana', 'Hervé', 'herveRavel', 'prop123', '0348901234', 'herve@prop.com'),
    (10,2, 'Andrianarisoa', 'Alice', 'aliceAndria', 'prop123', '0349012345', 'alice@prop.com'),
    (11,2, 'Rabenoro', 'Emilie', 'emilieRabe', 'prop123', '0340123456', 'emilie@prop.com'),
    (12,2, 'Randrianarivelo', 'Jacques', 'jacquesRandri', 'prop123', '0343456789', 'jacques@prop.com'),
    (13,2, 'Raharison', 'Sara', 'saraRahar', 'prop123', '0344567890', 'sara@prop.com'),
    -- -------------------------------------------------------- -- --------------------------------
    (14,3, 'Randrianantoandro', 'Michel', 'michelRandria', 'client123', '0341112233', 'michel@client.com'),
    (15,3, 'Razafimanantsoa', 'Isabelle', 'isabelleRazafi', 'client123', '0342233445', 'isabelle@client.com'),
    (16,3, 'Rabenja', 'François', 'francoisRabe', 'client123', '0343344556', 'francois@client.com'),
    (17,3, 'Ratsimba', 'Lucie', 'lucieRatsi', 'client123', '0344455667', 'lucie@client.com'),
    (18,3, 'Rakotobe', 'Alain', 'alainRakoto', 'client123', '0345566778', 'alain@client.com'),
    (19,3, 'Ramaroson', 'Caroline', 'carolineRama', 'client123', '0346677889', 'caroline@client.com'),
    (20,3, 'Andriambelo', 'Thierry', 'thierryAndria', 'client123', '0347788990', 'thierry@client.com'),
    (21,3, 'Rakotonirina', 'Mireille', 'mireilleRakoto', 'client123', '0348899001', 'mireille@client.com'),
    (22,3, 'Ravelo', 'Yves', 'yvesRavelo', 'client123', '0349900112', 'yves@client.com'),
    (23,3, 'Raharinirina', 'Julie', 'julieRahari', 'client123', '0341011123', 'julie@client.com');



INSERT INTO type_bien (id, nom, commission)
VALUES 
    (1, 'Maison', 5.00),
    (2, 'Appartement', 4.50),
    (3, 'Villa', 6.00),
    (4, 'Immeuble', 3.50);


INSERT INTO region (id, nom)
VALUES 
    (1, 'Antananarivo'),
    (2, 'Nosy Be'),
    (3, 'Tamatave'),
    (4, 'Fianarantsoa'),
    (5, 'Majunga');


INSERT INTO bien (id, type_id, proprietaire_id, region_id, nom, description, loyer, photos)
VALUES
    (1, 1, 3, 1, 'Maison à Ambohijatovo', 'Maison traditionnelle avec jardin.', 1800000, 'maison_ambohijatovo.jpg'),
    (2, 2, 4, 2, 'Appartement à Nosy Komba', 'Appartement moderne en bord de plage.', 2500000, 'appartement_nosykomba1.jpg,appartement_nosykomba2.jpg'),
    (3, 3, 5, 3, 'Villa à Tamatave', 'Villa spacieuse et élégante avec piscine.', 4000000, 'villa_tamatave1.jpg'),
    (4, 4, 6, 4, 'Immeuble à Fianarantsoa', 'Immeuble de bureaux récent.', 6000000, 'immeuble_fianarantsoa1.jpg'),
    (5, 1, 7, 1, 'Maison à Analamahitsy', 'Maison confortable près du centre-ville.', 2000000, 'maison_analamahitsy.jpg'),
    (6, 2, 8, 2, 'Appartement à Diego Suarez', 'Appartement avec vue sur la baie.', 1500000, 'appartement_diego.jpg'),
    (7, 3, 9, 3, 'Villa à Fort-Dauphin', 'Villa haut standing avec jardin tropical.', 5000000, 'villa_fortdauphin.jpg'),
    (8, 4, 10, 4, 'Immeuble à Antsirabe', 'Immeuble résidentiel avec commerces au rez-de-chaussée.', 7000000, 'immeuble_antsirabe.jpg'),
    (9, 1, 2, 5, 'Maison à Mahajanga', 'Maison agréable près de la plage.', 2200000, 'maison_mahajanga.jpg'),
    (10, 2, 1, 1, 'Appartement à Antananarivo', 'Appartement moderne en plein centre.', 1800000, 'appartement_tana.jpg');


INSERT INTO location (id, client_id, duree, date_debut)
VALUES
    (1, 4, 12, '2024-01-01'),  -- Michel loue la maison à Ambohijatovo
    (2, 5, 6, '2024-03-15'),   -- Isabelle loue l'appartement à Nosy Komba
    (3, 6, 24, '2024-05-01'),  -- François loue la villa à Tamatave
    (4, 7, 12, '2024-06-10'),  -- Lucie loue l'immeuble à Fianarantsoa
    (5, 8, 6, '2024-07-20'),   -- Alain loue la maison à Analamahitsy
    (6, 9, 18, '2024-09-01'),  -- Caroline loue l'appartement à Diego Suarez
    (7, 10, 12, '2024-10-05'), -- Thierry loue la villa à Fort-Dauphin
    (8, 3, 24, '2024-12-01'),  -- Mireille loue l'immeuble à Antsirabe
    (9, 2, 6, '2025-01-15'),   -- Yves loue la maison à Mahajanga
    (10, 1, 12, '2025-02-01'); -- Julie loue l'appartement à Antananarivo




-- 1. Afficher le chiffre d’affaires et les gains par mois de Mada-immo (filtre entre deux dates)

SELECT 
    DATE_TRUNC('month', l.date_debut) AS mois,
    SUM(b.loyer * l.duree) AS chiffre_affaires,
    SUM((b.loyer * l.duree) * (tb.commission / 100)) AS gains
FROM 
    location l
JOIN bien b ON b.id = l.client_id
JOIN type_bien tb ON tb.id = b.type_id
WHERE 
    l.date_debut BETWEEN '2024-01-01' AND '2024-12-31'
GROUP BY 
    DATE_TRUNC('month', l.date_debut)
ORDER BY 
    mois;


-- 2. Voir la liste de ses biens

SELECT 
    b.id AS id_bien,
    b.nom AS nom_bien,
    b.description,
    tb.nom AS type_bien,
    r.nom AS region,
    b.loyer,
    b.photos
FROM 
    bien b
JOIN type_bien tb ON b.type_id = tb.id
JOIN region r ON b.region_id = r.id
ORDER BY 
    b.nom;


-- 3. Consulter son chiffre d’affaires entre deux dates (pouvant inclure une date dans le futur)

SELECT 
    SUM(b.loyer * l.duree) AS chiffre_affaires_total
FROM 
    location l
JOIN bien b ON l.client_id = b.id
WHERE 
    l.date_debut BETWEEN '2024-01-01' AND '2025-12-31';


-- 4. Voir son loyer (à payer ou déjà payé) entre deux dates (pouvant inclure une date dans le futur)

SELECT 
    l.id AS id_location,
    c.nom AS client_nom,
    c.prenom AS client_prenom,
    b.nom AS bien_nom,
    l.duree,
    l.date_debut,
    (b.loyer * l.duree) AS montant_total
FROM 
    location l
JOIN bien b ON b.id = l.client_id
JOIN utilisateur c ON c.id = l.client_id
WHERE 
    l.date_debut BETWEEN '2024-01-01' AND '2025-12-31'
ORDER BY 
    l.date_debut;


