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



function getMember(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM team'
  );
  $memberTeam = $req->fetchAll(PDO::FETCH_ASSOC);
  return $memberTeam;
}



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

  
// récupération team member par role
$sql =$pdo->query('SELECT COUNT(*) as nb FROM team WHERE statut = 0');
$data_membre = $sql->fetch();
$admin =$data_membre['nb'];

$sql2 =$pdo->query('SELECT COUNT(*) as nb FROM team WHERE statut = 1');
$data_membre = $sql2->fetch();
$user =$data_membre['nb'];

$sql3 =$pdo->query('SELECT COUNT(*) as nb FROM team WHERE statut = 2');
$data_membre = $sql3->fetch();
$editeur =$data_membre['nb'];