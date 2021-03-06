<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/categories_functions.php';


/* #############################################################################

Suppression d'une categorie a partir catergories.php en Ajax

############################################################################# */

if(!empty($_POST)){

  
  $result = array();
  $id = $_POST['id'];
  $confirme = 'on';

  // validation en back de la confirmation de la suppression
    if(($_POST['confirmedelete']) !== $confirme ){

      $result['status'] = false;
      $result['notif'] = notif('error','Merci de confirmer la suppression');
  
    }else{

     //suppresion de la categorie de la BDD
    $req = $pdo->exec("DELETE FROM categories WHERE id_categorie = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','Categorie supprimée');

    $query = $pdo->query('SELECT * FROM categories');

     //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>Mots Clés</th>
                        <th>N° Site</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($cat = $query->fetch()){

        $result['resultat'] .= '<tr>';
          $result['resultat'] .= '<td>'.$cat['id_categorie'].'</td>';
          $result['resultat'] .= '<td><div class="img-logo"><i class="'.$cat['icone'].'"></i></div></td>';
          $result['resultat'] .= '<td>'.$cat['titre'].'</td>';
          $result['resultat'] .= '<td>'.$cat['motscles'].'</td>';
          $result['resultat'] .= '<td>'.getPostbyCar($pdo, $cat['id_categorie'] ).'</td>';
  
          if($Membre['statut'] == 0){
          $result['resultat'] .= '<td class="member_action">';
              $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$cat['id_categorie'].'"></input>';
              $result['resultat'] .= '<input type="button" class="editbtn" id="'.$cat['id_categorie'].'"></input>';
              $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
          $result['resultat'] .= '</td>';
          }
  
          $result['resultat'] .= '</tr>';
  
        }
  
        $result['resultat'] .= '</tbody>';

      $result['resultat'] .= '</table>';

    
      

  
  }

  echo json_encode($result);
  }
?>