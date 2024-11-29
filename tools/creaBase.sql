-- Crear la base de dades
CREATE DATABASE giro_agenda;
USE giro_agenda;

-- Crear les taules
CREATE TABLE usuari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    cognoms VARCHAR(255) NOT NULL,  -- Añadido para los apellidos
    email VARCHAR(255) NOT NULL UNIQUE,
    telefon VARCHAR(20) NOT NULL UNIQUE,
    dni VARCHAR(20) NOT NULL UNIQUE,  -- Añadido para el DNI
    data_naixement DATETIME NOT NULL,
    nom_usuari VARCHAR(50) NOT NULL UNIQUE,
    contrassenya VARCHAR(255) NOT NULL,
    data_creacio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    administrador BOOLEAN DEFAULT FALSE
);

CREATE TABLE tipus_activitat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    descripcio TEXT NOT NULL
);

CREATE TABLE espai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    ubicacio VARCHAR(255) NOT NULL,
    capacitat INT NOT NULL,
    descripcio TEXT NOT NULL
);

CREATE TABLE activitat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_espai INT,
    nom VARCHAR(255) NOT NULL,
    descripcio_breu TEXT NOT NULL,
    descripcio TEXT NOT NULL,
    data DATETIME NOT NULL,
    places_totals INT NOT NULL,
    places_ocupades INT DEFAULT 0,
    preu DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_espai) REFERENCES espai(id)
);

CREATE TABLE activitat_tipus (
    id_activitat INT,
    id_tipus_activitat INT,
    PRIMARY KEY (id_activitat, id_tipus_activitat),
    FOREIGN KEY (id_activitat) REFERENCES activitat(id),
    FOREIGN KEY (id_tipus_activitat) REFERENCES tipus_activitat(id)
);

CREATE TABLE organitzador (
    id_usuari INT,
    id_activitat INT,
    rol VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_usuari, id_activitat),
    FOREIGN KEY (id_usuari) REFERENCES usuari(id),
    FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE inscripcio (
    id_usuari INT,
    id_activitat INT,
    estat VARCHAR(50) NOT NULL,
    data_creacio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuari, id_activitat),
    FOREIGN KEY (id_usuari) REFERENCES usuari(id),
    FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE preferencies (
    id_usuari INT,
    id_tipus_activitat INT,
    data_registrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuari, id_tipus_activitat),
    FOREIGN KEY (id_usuari) REFERENCES usuari(id),
    FOREIGN KEY (id_tipus_activitat) REFERENCES tipus_activitat(id)
);

CREATE TABLE multimedia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruta VARCHAR(255) NOT NULL,
    tipus VARCHAR(100) NOT NULL,
    descripcio TEXT NOT NULL,
    estat VARCHAR(50) NOT NULL
);

CREATE TABLE activitat_multimedia (
    id_activitat INT,
    id_multimedia INT,
    PRIMARY KEY (id_activitat, id_multimedia),
    FOREIGN KEY (id_activitat) REFERENCES activitat(id),
    FOREIGN KEY (id_multimedia) REFERENCES multimedia(id)
);