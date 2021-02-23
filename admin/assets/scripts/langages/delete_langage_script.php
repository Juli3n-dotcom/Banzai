<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

Suppression d'un langage a partir langage.php en Ajax

############################################################################# */

if(!empty($_POST)){

  
  $result = array();
  $id = $_POST['id'];
  $img = $_POST['img'];
  $confirme = 'on';

  // validation en back de la confirmation de la suppression
    if(($_POST['confirmedelete']) !== $confirme ){

      $result['status'] = false;
      $result['notif'] = notif('error','Merci de confirmer la suppression');
  
    }else{

      //suppresion du logo
    $data = $pdo->query("SELECT * FROM pics WHERE id_pics = '$img'");
    $photo = $data->fetch(PDO::FETCH_ASSOC);

    $file =__DIR__.'/../../../../global/uploads/';
    $dir = opendir($file);
    unlink($file.$photo['img']);
    closedir($dir);

    $req1 = $pdo->exec("DELETE FROM pics WHERE id_pics = '$img'");

     //suppresion du langage de la BDD
    $req2 = $pdo->exec("DELETE FROM langages WHERE id_langage = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','langage supprimé');

    $query = $pdo->query('SELECT * FROM langages');

    
        //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th class="dnone">pics_id</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>N° Site</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($lang = $query->fetch()){

      $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$lang['id_langage'].'</td>';
        $result['resultat'] .= '<td class="dnone">'.$lang['pics_id'].'</td>';

        if($lang["pics_id"] != NULL){
          $result['resultat'] .= '<td><div class="img-logo" style="background-image: url(../global/uploads/'.getImg($pdo, $lang["pics_id"]).'")"></div></td>';
        }else{
          $result['resultat'] .= '<td> </td>';
        }

        $result['resultat'] .= '<td>'.$lang['titre'].'</td>';
        $result['resultat'] .= '<td>0</td>';

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