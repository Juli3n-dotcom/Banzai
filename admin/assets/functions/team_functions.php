<?php

// gestion de l'affichage
$membresParPage = 10;
$membresTotalesReq = $pdo->query('SELECT id_team_member FROM team');
$membresTotales = $membresTotalesReq->rowCount();
$pageTotales = ceil($membresTotales/$membresParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page']<=$pageTotales){
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];
}else{
    $pageCourante = 1;
}
$depart = ($pageCourante-1)*$membresParPage;

$Allmembres = $pdo->query('SELECT * FROM team ORDER BY date_enregistrement DESC LIMIT '.$depart.','.$membresParPage);



function getMemberBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM team
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $utilisateur =$req->fetch(PDO::FETCH_ASSOC);
     return $utilisateur ?: null;
      }

//count du nombre de membre admin
function countAdmin(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from team WHERE statut = 0");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de membre USER
function countUser(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from team WHERE statut = 1");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de membre editeur
function countEditeur(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from team WHERE statut = 2");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

// récupération des logos des categories | langages 
function getPhoto(PDO $pdo, INT $id)
{
  $data = $pdo->query("SELECT profil FROM photo WHERE id_photo = '$id'");
  $photo = $data->fetch(PDO::FETCH_ASSOC);
  return $photo['profil'];
}

function getSex(PDO $pdo,INT $sex){

  $civilite = '';

  if($sex === 0){
    $civilite =  'Monsieur';
  }else if($sex === 1){
    $civilite = 'Madame';
  }else{
    $civilite = 'Autre';
  }

  return $civilite;
}

function getStatut(PDO $pdo,INT $data){

  $statut = '';

  if($data === 0){
     $statut =  'Admin';
  }else if($data === 1){
     $statut = 'User';
  }else{
     $statut = 'Editeur';
  }

  return  $statut;
}

function getConfirm(PDO $pdo,INT $data){

  $confirmation = '';

  if($data === 0){
     $confirmation =  'NON';
  }else if($data === 1){
     $confirmation = 'OUI';
  }

  return  $confirmation;
}