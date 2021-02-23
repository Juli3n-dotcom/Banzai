<?php

//récupération des catégories
function getCat(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM categories'
  );
  $cat = $req->fetchAll(PDO::FETCH_ASSOC);
  return $cat;
}

//vérification sur category existe déja
function getCatBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM categories
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $cat =$req->fetch(PDO::FETCH_ASSOC);
     return $cat ?: null;
      }