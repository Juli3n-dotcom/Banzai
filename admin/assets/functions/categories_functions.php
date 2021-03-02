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

// récupération des posts selon catégorie
function getPostbyCar(pdo $pdo, INT $id){

  $query = $pdo ->query("SELECT count(categories_id) as nb from posts WHERE categories_id = '$id'");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

function getCatOrder($pdo){

  $query = $pdo->query("SELECT categories.*, COUNT(posts.categories_id) AS nb 
                          FROM categories 
                          LEFT JOIN posts  ON categories.id_categorie = posts.categories_id
                          GROUP BY id_categorie
                          ORDER by nb DESC
                          LIMIT 3");
  $data = $query->fetchAll(PDO::FETCH_ASSOC);

  // $count = $data['nb'];
  return $data;

}