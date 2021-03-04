<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/team_functions.php';

/* #############################################################################

vue d'un member a partir team.php en Ajax

############################################################################# */


if(isset($_POST['member_id'])){

  $result = '';
  $id = $_POST['member_id'];
  
  $query = $pdo->query("SELECT * FROM team WHERE id_team_member = '$id'");

  $result .='<div class="list_container">';

    $result .='<ul>';

    while($member = $query->fetch()){

      $date = str_replace('/', '-', $member['date_enregistrement']);
      $last_date = str_replace('/', '-', $member['last_login']);

      $result .= '<li>
                    <h6>ID : </h6>
                    <p>'.$member['id_team_member'].'</p>
                  </li>';
      $result .= '<li>
                    <h6>Nom : </h6>
                    <p>'. $member['nom'].'</p>
                  </li>';
      $result .= '<li>
                    <h6>Prénom : </h6>
                    <p>'. $member['prenom'].'</p>
                  </li>';
      $result .= '<li>
                    <h6>Email : </h6>
                    <p>'. $member['email'].'</p>
                  </li>';
      $result .= '<li>
                    <h6>Username : </h6>
                    <p>'. $member['username'].'</p>
                </li>';
      $result .= '<li>';  
        $result .= '<h6>Status : </h6>';     
        if($member['statut'] == 0){
          $result .= '<p class="badge admin">Admin</p>';
        }elseif($member['statut'] == 1){
          $result .= '<p class="badge user">User</p>';
        }else{
          $result .= '<p class="badge editer">Editeur</p>';
        }
      $result .= '</li>'; 

      if($Membre['statut'] == 0){

        $result .= '<li>'; 
          $result .= '<h6>Confirmation : </h6>'; 
          $result .= '<p>';
            if($member['confirmation'] == 0){
              $result .= '<p class="badge danger confirmation">Non</p>';
            }else{
              $result .= '<p class="badge success confirmation">Oui</p>';
            }
          $result .= '</p>';
        $result .= '</li>'; 

        $result .= '<li>
                    <h6>Derniére connexion : </h6>
                    <p>'. date('d-m-Y', strtotime($last_date)).'</p>
                  </li>';
        $result .= '<li>
                      <h6>Date d\'enregistrement : </h6>
                      <p>'.date('d-m-Y', strtotime($date)).'</p>
                    </li>';
      }

    }

    $result .='</ul>';

  $result .= '</div>';


  echo $result;
}


?>