DROP DATABASE IF EXISTS bdd_bibli;
CREATE database bdd_bibli;

USE bdd_bibli;

CREATE TABLE Auteurs (
    id INT PRIMARY KEY auto_increment,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    date_de_naissance DATE
);

CREATE TABLE Livres (
    id INT PRIMARY KEY auto_increment,
    titre VARCHAR(255),
    date_de_publication DATE,
    id_auteur INT,
    id_editeur INT,
    FOREIGN KEY (id_auteur) REFERENCES Auteurs(id)
);

CREATE TABLE Editeurs (
    id INT PRIMARY KEY auto_increment,
    nom VARCHAR(255),
    adresse VARCHAR(255)
);

CREATE TABLE Emprunteurs (
    id INT PRIMARY KEY auto_increment,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    adresse_email VARCHAR(255),
    mot_de_passe VARCHAR(255)
);

CREATE TABLE Emprunts (
    id INT PRIMARY KEY auto_increment,
    id_emprunteur INT,
    id_livre INT,
    date_d_emprunt DATE,
    date_de_retour DATE,
	FOREIGN KEY (id_emprunteur) REFERENCES Emprunteurs(id),
    FOREIGN KEY (id_livre) REFERENCES Livres(id)
);

SELECT * FROM Emprunts;