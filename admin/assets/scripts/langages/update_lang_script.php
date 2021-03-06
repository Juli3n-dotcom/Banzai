<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/langages_functions.php';

/* #############################################################################

Modification d'un langage a partir langage.php en Ajax via update_modal.php

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_name_lang'];
  $icone = $_POST['new_logo'];
  $number = $_POST['UpdateskillRange'];
  
  $query = $pdo->query("SELECT * FROM langages WHERE id_langage = '$id'");
  $thislang = $query->fetch(PDO::FETCH_ASSOC); 


  //modification du titre
  if($titre !== $thislang['titre']){

    if(getLangBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! ce langage existe déjà'); 
    
      }else{

      
      //modification du titre
    $req_update_lang = $pdo->prepare('UPDATE langages SET titre = :titre, icone = :icone, number = :number WHERE id_langage = :id');

    $req_update_lang->bindParam(':id',$id,PDO::PARAM_INT);
    $req_update_lang->bindValue(':titre',$titre);
    $req_update_lang->bindValue(':icone',$icone);
    $req_update_lang->bindValue(':number',$number);
    $req_update_lang->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','langage modifié');
    
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

  }


}

// Return result 
echo json_encode($result);
?>


  