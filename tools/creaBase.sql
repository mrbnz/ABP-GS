SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `basededades` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE USER 'usuari'@'localhost' IDENTIFIED by 'password';
GRANT USAGE ON *.* TO 'usuari'@'localhost';

GRANT ALL PRIVILEGES ON `basededades`.* TO 'usuari'@'localhost' WITH GRANT OPTION;

USE `basededades`;

DROP TABLE IF EXISTS `editorial`;
CREATE TABLE `editorial` (
  `idEditorial` int(11) NOT NULL,
  `nomEditorial` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `municipi` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `web` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefon` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
INSERT INTO `editorial`
(`idEditorial`,`nomEditorial`,`Provincia`,`Municipi`,`web`,`email`,`telefon`)
VALUES
('1','Bernitoons','Girona  ','Montagut i Oix','www.bernitoons.com','bernat@bernitoons.com','638232927'),
('2','Bringas y Thiers','Girona  ','Riells i Viabrea','bringasythiers.wordpress.com','bringasythiers@gmail.com','687549625'),
('3','Eol Serveis Girona, S.L. - Edicions del Reremús','Girona  ','Salt  ','www.edicionsreremus.cat','edicionsdelreremus@gmail.com',''),
('4','History & Heraldry','Girona  ','Lloret de Mar','www.hhiberica.com','narcis@hhiberica.com','972363657'),
('5','Pànic Editors','Girona  ','Palafrugell','www.paniceditors.cat','comunicacio@paniceditors.cat','650529342');
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`idEditorial`);
  
ALTER TABLE `editorial`
  MODIFY `idEditorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

DROP TABLE IF EXISTS `llibre`;
CREATE TABLE `llibre` (
  `idLlibre` int(11) NOT NULL,
  `isbn` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `titol` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `autors` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEditorial` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `anyPublicacio` int(11),
  `elTenim` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
INSERT INTO `llibre`
(`idLlibre`,`titol`,`autors`,`isbn`,`anyPublicacio`,`idEditorial`,`elTenim`)
VALUES
('1','Doble : hombre muerto','Costa Faura, Bernat','9788412054804','2019','1','1'),
('2','Les quimeres','Nerval, Gérard de (1808-1855)','9788412038804','2019','5','1'),
('3','Daniela salva la Navidad','','9788417983420','2019','4','1'),
('4','Aitana salva la Navidad','','9788417983147','2019','4','0'),
('5','María ¡Papá Noel necesita tu ayuda!','','9788417983772','2019','4','0'),
('6','Manual del perfecto enfermo : ensayo de mejora ','Urbano García, Rafael','9788412022100','2019','2','1'),
('7','Los amigos, los amantes y la muerte','','9788412022117','2019','2','0'),
('8','Memoranda','Pérez Galdós, Benito (1843-1920)','9788412022124','2019','2','0'),
('9',"Sovint m'aturaria en els teus ulls",'Laguarda Darna, Francesca (1955-)','9788412057805','2019','3','1'),
('10','Nit i llum de lluna','Thoreau, Henry David (1817-1862)','9788412057812','2019','3','1');

ALTER TABLE `llibre`
  ADD PRIMARY KEY (`idLlibre`);
  
ALTER TABLE `llibre`
  MODIFY `idLLIBRE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

DROP TABLE IF EXISTS `editorialISBN`;
CREATE TABLE `editorialISBN` (
  `idEditorialIsbn` int(11) NOT NULL,
  `idEditorial` int(11) NOT NULL,
  `isbn` varchar(13) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
INSERT INTO `editorialISBN`
(`idEditorialIsbn`,`idEditorial`,`ISBN`)
VALUES
('1','1','97884120548'),
('2','2','97884120221'),
('3','3','97884120578'),
('4','4','9788417983'),
('5','5','97884120667'),
('6','6','97884120388');
ALTER TABLE `editorialISBN`
  ADD PRIMARY KEY (`idEditorialIsbn`);
  
ALTER TABLE `editorialISBN`
  MODIFY `idEditorialIsbn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

COMMIT;

