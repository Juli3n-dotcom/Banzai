DROP DATABASE IF EXISTS BANZAI;
CREATE DATABASE BANZAI
CHARACTER
SET utf8mb4
COLLATE utf8mb4_unicode_ci;
USE FAIR_DB;

CREATE TABLE photo
(
id_photo INT(3) NOT NULL AUTO_INCREMENT,
 profil VARCHAR (255) NOT NULL,
 PRIMARY KEY (id_photo)
)ENGINE=INNODB;

CREATE TABLE team
(
id_team_member INT(3) NOT NULL AUTO_INCREMENT,
civilite INT (3) NOT NULL,
username VARCHAR (255) NOT NULL,
nom VARCHAR (255) NOT NULL,
prenom VARCHAR (255) NOT NULL,
email VARCHAR (50) NOT NULL,
password VARCHAR (60) NOT NULL,
photo_id INT (3) DEFAULT NULL,
statut INT (3) NOT NULL,
date_enregistrement DATETIME NOT NULL,
last_login DATETIME DEFAULT NULL,
confirmation TINYINT DEFAULT NULL,
token VARCHAR (255) DEFAULT NULL,
name VARCHAR (255) NOT NULL,
  PRIMARY KEY (id_team_member),
      CONSTRAINT fk_team_member_photo
      FOREIGN KEY (photo_id)
      REFERENCES  photo(id_photo)
      ON DELETE SET NULL
)ENGINE=INNODB;


CREATE TABLE online
(
id INT(3)NOT NULL AUTO_INCREMENT,
time int(255),
user_ip VARCHAR (255) NOT NULL,
  PRIMARY KEY (id)
)ENGINE=INNODB;


CREATE TABLE recuperation
(
id INT(3)NOT NULL
AUTO_INCREMENT,
email varchar(255),
code INT (11),
confirm TINYINT,
  PRIMARY KEY(id)
)ENGINE=INNODB;

CREATE TABLE notification
(
id_notification INT(3)NOT NULL AUTO_INCREMENT,
class varchar(30),
message varchar(255),
user INT(3) DEFAULT NULL,
date_enregistrement DATETIME NOT NULL,
  PRIMARY KEY (id_notification),
  CONSTRAINT fk_notif_auteur
      FOREIGN KEY  (user)
      REFERENCES  team(id_team_member)
      ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE pics
(
id_pics INT(3) NOT NULL AUTO_INCREMENT,
img VARCHAR (255) NOT NULL,
 PRIMARY KEY (id_pics)
)ENGINE=INNODB;

CREATE TABLE langages
(
  id_langage INT(3)NOT NULL AUTO_INCREMENT,
  titre VARCHAR(255),
  icone VARCHAR(255) DEFAULT NULL,
  number INT(3)DEFAULT NULL,
    PRIMARY KEY (id_langage)
)ENGINE=INNODB;

CREATE TABLE categories
(
  id_categorie INT(3)NOT NULL AUTO_INCREMENT,
  titre VARCHAR(255),
  motscles TEXT(255),
   icone VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_categorie)
)ENGINE=INNODB;


CREATE TABLE cms
(
  id_cms INT(3)NOT NULL AUTO_INCREMENT,
  titre VARCHAR(255),
  pics_id INT(3) DEFAULT NULL,
    PRIMARY KEY (id_cms),
    CONSTRAINT fk_cms_pics
      FOREIGN KEY  (pics_id)
      REFERENCES  pics(id_pics)
      ON DELETE SET NULL
)ENGINE=INNODB;

-- post avec une seule categorie et un seul langage
CREATE TABLE posts
(
id_post INT(3) NOT NULL AUTO_INCREMENT,
auteur INT (3) DEFAULT NULL,
titre VARCHAR (255) NOT NULL,
contenu TEXT NOT NULL,
url VARCHAR (255) NOT NULL,
pics_id INT(3) DEFAULT NULL,
categories_id INT(11) DEFAULT NULL,
date_publication DATETIME NOT NULL,
est_publie TINYINT NOT NULL,
  PRIMARY KEY(id_post),
    CONSTRAINT fk_post_auteur
      FOREIGN KEY  (auteur)
      REFERENCES  team(id_team_member)
      ON DELETE CASCADE,
    CONSTRAINT fk_pics_photo
      FOREIGN KEY  (pics_id)
      REFERENCES  pics(id_pics)
      ON DELETE SET NULL,
    CONSTRAINT fk_post_categories
        FOREIGN KEY (categories_id)
        REFERENCES categories(id_categorie)
        ON DELETE SET NULL
)ENGINE=INNODB;

-- CREATE TABLE posts
-- (
-- id_post INT(3) NOT NULL AUTO_INCREMENT,
-- auteur INT (3) DEFAULT NULL,
-- titre VARCHAR (255) NOT NULL,
-- contenu TEXT NOT NULL,
-- url VARCHAR (255) NOT NULL,
-- pics_id INT(3) DEFAULT NULL,
-- categories_id VARCHAR (20) DEFAULT NULL,
-- langages_id VARCHAR (20) DEFAULT NULL,
-- date_publication DATETIME NOT NULL,
-- est_publie TINYINT NOT NULL,
--   PRIMARY KEY(id_post),
--     CONSTRAINT fk_post_auteur
--       FOREIGN KEY  (auteur)
--       REFERENCES  team(id_team_member)
--       ON DELETE CASCADE,
--     CONSTRAINT fk_pics_photo
--       FOREIGN KEY  (pics_id)
--       REFERENCES  pics(id_pics)
--       ON DELETE SET NULL
-- )ENGINE=INNODB;