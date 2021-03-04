<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/team_functions.php';

/* #############################################################################

delete d'un member a partir team.php en Ajax

############################################################################# */



if(!empty($_POST)){

  $result = array();
  $id = $_POST['id'];
  $confirme = 'on';



  if(($_POST['confirmedelete']) !== $confirme ){

    $result['status'] = false;
    $result['notif'] = notif('error','Merci de confirmer la suppression');

  }else{

     //recherche si il existe une photo de profil
     $data = $pdo->query("SELECT photo_id FROM team WHERE id_team_member = '$id'");
     $img_id = $data->fetch(PDO::FETCH_ASSOC);
     
     // si image de profil on supprime la photo
     if($img_id['photo_id'] !== null){

      $img = $img_id['photo_id'];

      $data = $pdo->query("SELECT profil FROM photo WHERE id_photo = '$img'");
      $photo = $data->fetch(PDO::FETCH_ASSOC);

      
      $file =__DIR__.'/../../uploads/';
      $dir = opendir($file);
      unlink($file.$photo['profil']);
      closedir($dir);

      $req1 = $pdo->exec("DELETE FROM photo WHERE id_photo = '$img'");

     }

     //suppresion du membre de la BDD
    $req2 = $pdo->exec("DELETE FROM team WHERE id_team_member = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','Membre supprimé');

      //retour ajax card
      $result['cards'] = '<div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-shield"></i>
        <div>
          <h5>Admin</h5>
          <h4>'.countAdmin($pdo).'</h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="">View all</a>
      </div>
  </div>';

$result['cards'] .= '<div class="card__single">
      <div class="card__body">
        <i class="fas fa-user"></i>
        <div>
          <h5>User</h5>
          <h4>'.countUser($pdo).'</h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="">View all</a>
    </div>
  </div>';

$result['cards'] .= '<div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-edit"></i>
        <div>
            <h5>Editeur</h5>
            <h4>'. countEditeur($pdo).'</h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="">View all</a>
      </div>
    </div>';

// préparation retour Ajax
$query = $pdo->query('SELECT * FROM team');

//retour ajax table
$result['resultat'] = '<table>';

$result['resultat'] .= '<thead>
                <tr>
                  <th>ID</th>
                  <th class="dnone">Civilité</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Photo</th>
                  <th>Email</th>
                  <th>Status</th>';
                  if($Membre['statut'] == 0){
                    $result['resultat'] .= '<th>Confirmation</th>';
                    $result['resultat'] .= '<th>Actions</th>';
                  }else{
                    $result['resultat'] .= '<th>Action</th>';
                  }
                  
$result['resultat'] .=  '</tr>
            </thead>';

$result['resultat'] .= '<tbody>';

while($member = $query->fetch()){

  $result['resultat'] .= '<tr>';
    $result['resultat'] .= '<td>'.$member['id_team_member'].'</td>';
    $result['resultat'] .= '<td class="dnone">'.$member['civilite'].'</td>';
    $result['resultat'] .= '<td>'.$member['nom'].'</td>';
    $result['resultat'] .= '<td>'.$member['prenom'].'</td>';
    $result['resultat'] .= ' <td class="td-team">';
      if($member['photo_id'] == NULL){
        if($member['civilite'] == 0) {
          $result['resultat'] .= '<div class="img-profil" style="background-image: url(assets/img/male.svg)"></div>';
          }elseif($member['civilite'] == 1){
          $result['resultat'] .= '<div class="img-profil" style="background-image: url(assets/img/female.svg)"></div>';
        }else{
          $result['resultat'] .= '<div class="img-profil" style="background-image: url(assets/img/profil.svg)"></div>';
        }
      }else{
        $result['resultat'] .= '<div class="img-profil" style="background-image: url(assets/uploads/' .getPhoto($pdo, $member['photo_id']). ' )"></div>';
      }
    $result['resultat'] .= '</td>';
    $result['resultat'] .= '<td><a href="mailto:'.$member['email'].'" class="email_member">'.$member['email'].'</a></td>';

    $result['resultat'] .= '<td>';
      if($member['statut'] == 0){
        $result['resultat'] .= '<p class="badge admin">Admin</p>';
      }elseif($member['statut'] == 1){
        $result['resultat'] .= '<p class="badge user">User</p>';
      }else{
        $result['resultat'] .= '<p class="badge editer">Editeur</p>';
      }
    $result['resultat'] .= '</td>';

    if($Membre['statut'] == 0){
      $result['resultat'] .= '<td class="dnone"><i>'.$member['confirmation'].'</i></td>';
      $result['resultat'] .= '<td>';
        if($member['confirmation'] == 0){
          $result['resultat'] .= '<p class="badge danger confirmation">Non</p>';
        }else{
          $result['resultat'] .= '<p class="badge success confirmation">Oui</p>';
        }
      $result['resultat'] .= '</td>';
    }

    $result['resultat'] .= '<td class="member_action">';
      $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$member['id_team_member'].'"></input>';

      if($Membre['statut'] == 0){
        $result['resultat'] .= '<input type="button" class="editbtn" id="'.$member['id_team_member'].'"></input>';
        $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
      }
    $result['resultat'] .= '</td>';

    $result['resultat'] .= '</tr>';

}

$result['resultat'] .= '</tbody>';

$result['resultat'] .= '</table>';

    

  }


// Return result 
echo json_encode($result);
}



?>