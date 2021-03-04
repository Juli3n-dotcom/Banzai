<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/team_functions.php';

/* #############################################################################

Update d'un member a partir team.php en Ajax

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $civilite = $_POST['update_civilite'];
  $username = $_POST['update_username'];
  $name = $_POST['update_name'];
  $prenom = $_POST['update_prenom'];
  $email = $_POST['update_email'];
  $statut = $_POST['update_statut'];
  $confime = $_POST['update_confirme'];

  $data = $pdo->query("SELECT * FROM team WHERE id_team_member = '$id'");
  $thisMembre = $data->fetch(PDO::FETCH_ASSOC);

  if($name !== $thisMembre['nom'] And !preg_match('~^[a-zA-Z-]+$~',$name)){

  $result['status'] = false;
  $result['notif'] = notif('warning','oups! il manque le nom'); 

  }elseif($prenom !== $thisMembre['prenom'] And !preg_match('~^[a-zA-Z-]+$~',$prenom)){

  $result['status'] = false;
  $result['notif'] = notif('warning','oups! il manque le prénom'); 


  }elseif($username !== $thisMembre['username'] And getMemberBy($pdo, 'username', $username)!==null){

  $result['status'] = false;
  $result['notif'] = notif('warning','pseudo déjà utilisé'); 

  }elseif($email !== $thisMembre['email'] And getMemberBy($pdo, 'email', $email)!==null){

  $result['status'] = false;
  $result['notif'] = notif('warning','email déjà utilisé'); 

  }elseif($email !== $thisMembre['email'] And !filter_var($email, FILTER_VALIDATE_EMAIL)){

    $result['status'] = false;
    $result['notif'] = notif('warning','email non valide ou manquant'); 

  }else{

    $req_update = $pdo->prepare('UPDATE team SET 
                                civilite = :civilite,
                                username = :username,
                                nom = :nom,
                                prenom = :prenom,
                                email = :email,
                                statut = :statut,
                                confirmation = :confirmation
                                WHERE id_team_member = :id
                                ');

  $req_update->bindParam(':id',$id,PDO::PARAM_INT);
  $req_update->bindValue(':civilite',$civilite);
  $req_update->bindParam(':username',$username);
  $req_update->bindParam(':nom',$name);
  $req_update->bindParam(':prenom',$prenom);
  $req_update->bindParam(':email',$email);
  $req_update->bindValue(':statut',$statut);
  $req_update->bindValue(':confirmation',$confime);
  $req_update->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Membre Modifié');

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

}


// Return result 
echo json_encode($result);

?>