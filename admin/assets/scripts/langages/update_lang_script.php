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
  

  $query = $pdo->query("SELECT * FROM langages WHERE id_langage = '$id'");
  $thislang = $query->fetch(PDO::FETCH_ASSOC); 


  //modification du titre
  if($titre !== $thislang['titre']){

    if(getLangBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! ce langage existe déjà'); 
    
      }else{

      if(!empty($_FILES['new_logo']['tmp_name'])){

        $img = $thislang['pics_id'];
        $extension = pathinfo($_FILES['new_logo']['name'], PATHINFO_EXTENSION);
        $path = __DIR__.'/../../../../global/uploads';
        // Allow certain file formats 
        $allowTypes = array( 'svg','jpg', 'png', 'jpeg'); 

        if($_FILES['new_logo']['error'] !== UPLOAD_ERR_OK) {

          $result['status'] = false;
          $result['notif'] = notif('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['new_logo']['error']);
  
        }elseif($_FILES['new_logo']['size']<12 || !in_array($extension, $allowTypes)){
  
          $result['status'] = false;
          $result['notif'] = notif('error','Le fichier envoyé n\'est pas une image'); 
  
        }else{

          do{
            $filename = bin2hex(random_bytes(16));
            $complete_path = $path.'/'.$filename.'.'.$extension;
          }while (file_exists( $complete_path));
  
        }

        if(!move_uploaded_file($_FILES['new_logo']['tmp_name'],$complete_path)){
  
          $result['status'] = false;
          $result['notif'] = notif('error','La photo n\'a pas pu être enregistrée'); 
  
        }else{

          //suppresion de l'ancien  logo
          $data = $pdo->query("SELECT * FROM pics WHERE id_pics = '$img'");
          $pics = $data->fetch(PDO::FETCH_ASSOC);

          $file =__DIR__.'/../../../../global/uploads/';
          $dir = opendir($file);
          unlink($file.$pics['img']);
          closedir($dir);

          $req_update_pics = $pdo->prepare('UPDATE pics SET img = :img WHERE id_pics = :id');

          $req_update_pics->bindParam(':id',$img,PDO::PARAM_INT);
          $req_update_pics->bindValue(':img',$filename.'.'.$extension);
          $req_update_pics->execute();
        }

      }

      //modification du titre
    $req_update_lang = $pdo->prepare('UPDATE langages SET titre = :titre WHERE id_langage = :id');

    $req_update_lang->bindParam(':id',$id,PDO::PARAM_INT);
    $req_update_lang->bindValue(':titre',$titre);
    $req_update_lang->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','langage modifié');
    
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


  }else{

    // modification uniquement du logo
    if(!empty($_FILES['new_logo']['tmp_name'])){

      $img = $thislang['pics_id'];
      $extension = pathinfo($_FILES['new_logo']['name'], PATHINFO_EXTENSION);
      $path = __DIR__.'/../../../../global/uploads';
      // Allow certain file formats 
      $allowTypes = array( 'svg','jpg', 'png', 'jpeg'); 

      if($_FILES['new_logo']['error'] !== UPLOAD_ERR_OK) {

        $result['status'] = false;
        $result['notif'] = notif('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['new_logo']['error']);

      }elseif($_FILES['new_logo']['size']<12 || !in_array($extension, $allowTypes)){

        $result['status'] = false;
        $result['notif'] = notif('error','Le fichier envoyé n\'est pas une image'); 

      }else{

        do{
          $filename = bin2hex(random_bytes(16));
          $complete_path = $path.'/'.$filename.'.'.$extension;
        }while (file_exists( $complete_path));

      }

      if(!move_uploaded_file($_FILES['new_logo']['tmp_name'],$complete_path)){

        $result['status'] = false;
        $result['notif'] = notif('error','La photo n\'a pas pu être enregistrée'); 

      }else{

        //suppresion de l'ancien  logo si le titre n'a pas été modifié
        $data = $pdo->query("SELECT * FROM pics WHERE id_pics = '$img'");
        $pics = $data->fetch(PDO::FETCH_ASSOC);

        $file =__DIR__.'/../../../../global/uploads/';
        $dir = opendir($file);
        unlink($file.$pics['img']);
        closedir($dir);

        $req_update_pics = $pdo->prepare('UPDATE pics SET img = :img WHERE id_pics = :id');

        $req_update_pics->bindParam(':id',$img,PDO::PARAM_INT);
        $req_update_pics->bindValue(':img',$filename.'.'.$extension);
        $req_update_pics->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','langage modifié');
    
    $query = $pdo->query('SELECT * FROM langages');

    //retour ajax
    $result['resultat'] = '<table>';

      $result['resultat'] .= '<thead>
                        <tr>
                          <th>ID</th>
                          <th class="dnone">Photo_id</th>
                          <th>Logo</th>
                          <th>Titre</th>
                          <th>N° Site</th>';
                          if($Membre['statut'] == 0){
                            $result['resultat'] .= '<th>Action</th>';
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

    }
  }

  

}

// Return result 
echo json_encode($result);
?>


  