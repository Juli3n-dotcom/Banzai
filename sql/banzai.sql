DROP DATABASE IF EXISTS BANZAI;
CREATE DATABASE BANZAI
CHARACTER
SET utf8mb4
COLLATE utf8mb4_unicode_ci;
USE FAIR_DB;

CREATE TABLE photo
(
       id_photo INT(3) NOT NULL
       AUTO_INCREMENT,
 profil VARCHAR
       (255) NOT NULL,
 PRIMARY KEY
       (id_photo)
)ENGINE=INNODB;

       CREATE TABLE team
       (
              id_team_member INT(3) NOT NULL
              AUTO_INCREMENT,
        civilite INT
              (3) NOT NULL,
 username VARCHAR
              (255) NOT NULL,
 nom VARCHAR
              (255) NOT NULL,
 prenom VARCHAR
              (255) NOT NULL,
 email VARCHAR
              (50) NOT NULL,
 password VARCHAR
              (60) NOT NULL,
 photo_id INT
              (3) DEFAULT NULL,
 statut INT
              (3) NOT NULL,
 date_enregistrement DATETIME NOT NULL,
 confirmation TINYINT DEFAULT NULL,
 token VARCHAR
              (255) DEFAULT NULL,
 name VARCHAR
              (255) NOT NULL,
 PRIMARY KEY
              (id_team_member),
 CONSTRAINT fk_team_member_photo
FOREIGN KEY
              (photo_id)
      REFERENCES  photo
              (id_photo)
      ON
              DELETE
              SET NULL
              )ENGINE=INNODB;


              CREATE TABLE online
              (
                     id INT(3)NOT NULL
                     AUTO_INCREMENT,
    time int
                     (255),
    user_ip VARCHAR
                     (255) NOT NULL,
    PRIMARY KEY
                     (id)
)ENGINE=INNODB;


                     CREATE TABLE recuperation
                     (
                            id INT(3)NOT NULL
                            AUTO_INCREMENT,
    email varchar
                            (255),
    code INT
                            (11),
    confirm TINYINT,
    PRIMARY KEY
                            (id)
)ENGINE=INNODB;