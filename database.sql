CREATE DATABASE IF NOT EXISTS nexplay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nexplay;
CREATE TABLE IF NOT EXISTS usuarios (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(80) NOT NULL, apellido VARCHAR(80) NOT NULL,
dni VARCHAR(20) NOT NULL UNIQUE, email VARCHAR(254) NOT NULL UNIQUE,
password_hash VARCHAR(255) NOT NULL, rol VARCHAR(20) NOT NULL DEFAULT 'usuario',
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, archivado_en TIMESTAMP NULL DEFAULT NULL);
CREATE TABLE IF NOT EXISTS juegos (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(120) NOT NULL,
categoria VARCHAR(80) NOT NULL, plataforma VARCHAR(100) NOT NULL,
descripcion TEXT, imagen VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL DEFAULT 1,
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
INSERT INTO juegos(nombre,categoria,plataforma,descripcion) VALUES
('Aventura espacial','Aventura','PC','Un viaje por planetas desconocidos.'),
('Carreras urbanas','Carreras','PC / Consolas','Competí en circuitos de una gran ciudad.'),
('Reino de fantasía','Rol','PC','Explorá un mundo fantástico y completá misiones.');