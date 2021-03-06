<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

Suppression d'un langage a partir langage.php en Ajax

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


     //suppresion du langage de la BDD
    $req = $pdo->exec("DELETE FROM langages WHERE id_langage = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','langage supprimé');

    $query = $pdo->query('SELECT * FROM langages');

    
        //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>%</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($lang = $query->fetch()){

      $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$lang['id_langage'].'</td>';
        $result['resultat'] .= '<td><div class="img-logo"><i class="'.$lang['icone'].'"></i></div></td>';
        $result['resultat'] .= '<td>'.$lang['titre'].'</td>';
        $result['resultat'] .= '<td>'.$lang['number'].' %</td>';

        if($Membre['statut'] == 0){
        $result['resultat'] .= '<td class="member_action">';
            $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$lang['id_langage'].'"></input>';
            $result['resultat'] .= '<input type="button" class="editbtn" id="'.$lang['id_langage'].'"></input>';
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