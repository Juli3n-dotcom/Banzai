<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/langages_functions.php';


/* #############################################################################

Ajout d'un langage a partir langage.php en Ajax

############################################################################# */


$result = array(); 

// If form is submitted 
if(!empty($_POST)){ 

  $titre = $_POST['add_name_lang'];

  if(getLangBy($pdo,'titre',$titre)!==null){

    $result['status'] = false;
    $result['notif'] = notif('error','oups! ce langage existe déjà'); 
  
  }elseif(empty($_FILES["add_logo"]["tmp_name"])){

    $result['status'] = false;
    $result['notif'] = notif('error','oups!  il manque le logo'); 

  }else{

    $extension = pathinfo($_FILES['add_logo']['name'], PATHINFO_EXTENSION);
    $path = __DIR__.'/../../../../global/uploads';
    // Allow certain file formats 
    $allowTypes = array('svg', 'jpg', 'png', 'jpeg'); 

    if($_FILES['add_logo']['error'] !== UPLOAD_ERR_OK) {

      $result['status'] = false;
      $result['notif'] = notif('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['add_logo']['error']);

    }elseif($_FILES['add_logo']['size']<12 || !in_array($extension, $allowTypes)){

      $result['status'] = false;
      $result['notif'] = notif('error','Le fichier envoyé n\'est pas une image'); 

    }else{


      do{
        $filename = bin2hex(random_bytes(16));
        $complete_path = $path.'/'.$filename.'.'.$extension;
      }while (file_exists( $complete_path));

   }

   if(!move_uploaded_file($_FILES['add_logo']['tmp_name'],$complete_path)){

    $result['status'] = false;
    $result['notif'] = notif('error','La photo n\'a pas pu être enregistrée'); 

    }else{

      $req1 = $pdo->prepare('INSERT INTO pics(img) VALUES (:img)');
                  
      $req1->bindValue(':img',$filename.'.'.$extension);
      $req1->execute();

  
      }


      $img = $pdo-> lastInsertId();
      
      $req2 = $pdo->prepare('INSERT INTO langages(titre, pics_id) VALUES (:name,:img)');
        
            $req2->bindParam(':name',$titre);
            $req2->bindValue(':img',$img);
            $req2->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Nouveau langage ajouté');

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

  }

// Return result 
echo json_encode($result);

?>