<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/team_functions.php';

/* #############################################################################

vue all admin a partir team.php en Ajax

############################################################################# */

$result = array(); 

$query = $pdo->query('SELECT * FROM team WHERE statut = 0');

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

//reset
$result['reset'] = '<button id="reset_team_table">
                      <i class="far fa-eye"></i>
                          Voir tous
                    </button>';

// Return result 
echo json_encode($result);
?>