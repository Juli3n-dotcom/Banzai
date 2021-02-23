<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/categories_functions.php';


/* #############################################################################

Ajout d'une categorie a partir categories.php en Ajax

############################################################################# */


$result = array();

if(!empty($_POST)){

    $titre = $_POST['add_name_cat'];
    $word = $_POST['add_word_cat'];
   

    if(getCatBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups cette catégorie existe déjà'); 

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
      
      $req2 = $pdo->prepare('INSERT INTO categories(titre, motscles, pics_id) VALUES (:name, :motscles, :img)');
        
            $req2->bindParam(':name',$titre);
            $req2->bindParam(':motscles',$word);
            $req2->bindValue(':img',$img);
            $req2->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Nouvelle categorie ajoutée');

    $query = $pdo->query('SELECT * FROM categories');

     //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th class="dnone">pics_id</th>
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
        $result['resultat'] .= '<td class="dnone">'.$cat['pics_id'].'</td>';

        if($cat["pics_id"] != NULL){
          $result['resultat'] .= '<td><div class="img-logo" style="background-image: url(../global/uploads/'.getImg($pdo, $cat["pics_id"]).'")"></div></td>';
        }else{
          $result['resultat'] .= '<td> </td>';
        }

        $result['resultat'] .= '<td>'.$cat['titre'].'</td>';
        $result['resultat'] .= '<td>'.$cat['motscles'].'</td>';
        $result['resultat'] .= '<td>0</td>';

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
       
}

// Return result 
echo json_encode($result);

?>