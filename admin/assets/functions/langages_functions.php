<?php

//récupération des posts
function getLang(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM langages'
  );
  $lang = $req->fetchAll(PDO::FETCH_ASSOC);
  return $lang;
}


//vérification si langage existe déja
function getLangBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM langages
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $langage =$req->fetch(PDO::FETCH_ASSOC);
     return $langage ?: null;
      }


