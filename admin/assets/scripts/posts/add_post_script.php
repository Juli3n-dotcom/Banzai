<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/posts_functions.php';
require_once __DIR__ . '/../../functions/categories_functions.php';

/* #############################################################################

Ajout d'un post a partir posts.php en Ajax

############################################################################# */

$result = array(); 

if(!empty($_POST)){ 

  $auteur = $_POST['auteur_id'];
  $titre = $_POST['add_titre_post'];
  $contenu = $_POST['add_contenu_post'];
  $url = $_POST['add_url_post'];
  $cats = $_POST['cat'];

  if(empty($titre)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque le titre'); 

  }elseif(getPostBy($pdo,'titre',$titre)!==null){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! ce post existe déjà'); 

  }elseif(empty($contenu)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque une description'); 

  }elseif(empty($url)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque l\'adresse du site'); 

  }elseif(empty($_FILES["add_img"]["tmp_name"])){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups!  il manque le logo'); 

  }else{

    //insertion de l'image
    $extension = pathinfo($_FILES['add_img']['name'], PATHINFO_EXTENSION);
    $path = __DIR__.'/../../../../global/uploads';
    // Allow certain file formats 
    $allowTypes = array('svg', 'jpg', 'png', 'jpeg'); 

    if($_FILES['add_img']['error'] !== UPLOAD_ERR_OK) {

      $result['status'] = false;
      $result['notif'] = notif('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['add_img']['error']);

    }elseif($_FILES['add_img']['size']<12 || !in_array($extension, $allowTypes)){

      $result['status'] = false;
      $result['notif'] = notif('error','Le fichier envoyé n\'est pas une image'); 

    }else{


      do{
        $filename = bin2hex(random_bytes(16));
        $complete_path = $path.'/'.$filename.'.'.$extension;
      }while (file_exists( $complete_path));

   }

   if(!move_uploaded_file($_FILES['add_img']['tmp_name'],$complete_path)){

    $result['status'] = false;
    $result['notif'] = notif('error','La photo n\'a pas pu être enregistrée'); 

    }else{

      $req1 = $pdo->prepare('INSERT INTO pics(img) VALUES (:img)');
                  
      $req1->bindValue(':img',$filename.'.'.$extension);
      $req1->execute();

  
      }

      $img = $pdo-> lastInsertId();

      if(empty($cats)){

        $cats = NULL;

      }
      
      $req2 = $pdo->prepare('INSERT INTO posts(auteur,
                                               titre, 
                                              contenu, 
                                              url, 
                                              pics_id,
                                              categories_id,
                                              date_publication,
                                              est_publie) 
                                    VALUES (:auteur,
                                            :titre,
                                            :contenu, 
                                            :url, 
                                            :img,
                                            :categories_id,
                                            :date,
                                            :publie)');

      $req2->bindParam(':auteur',$auteur,PDO::PARAM_INT);
      $req2->bindParam(':titre',$titre);
      $req2->bindParam(':contenu',$contenu);
      $req2->bindParam(':url',$url);
      $req2->bindValue(':img',$img);
      $req2->bindParam(':categories_id',$cats,PDO::PARAM_INT);
      $req2->bindValue(':date',(new DateTime())->format('Y-m-d H:i:s'));
      $req2->bindValue(':publie',isset($_POST['est_publie']),PDO::PARAM_BOOL);
      $req2->execute();

      $result['status'] = true;
      $result['notif'] = notif('success','Nouveau post ajouté');

      //retour ajax card
      $result['cards'] = '<div class="card__single">
                            <div class="card__body">
                              <i class="fas fa-folder-open"></i>
                              <div>
                                <h5>Tous les posts</h5>
                                <h4>'.countPosts($pdo).'</h4>
                              </div>
                            </div>
                            <div class="card__footer">
                              <a href="">View all</a>
                            </div>
                        </div>';
      
      $result['cards'] .= '<div class="card__single">
                            <div class="card__body">
                              <i class="far fa-eye"></i>
                              <div>
                                <h5>Publiés</h5>
                                <h4>'.countPostsPublie($pdo).'</h4>
                              </div>
                            </div>
                            <div class="card__footer">
                              <a href="">View all</a>
                          </div>
                        </div>';

      $result['cards'] .= '<div class="card__single">
                            <div class="card__body">
                                <i class="far fa-eye-slash"></i>
                              <div>
                                  <h5>Non Publiés</h5>
                                  <h4>'. countPostsNonPublie($pdo).'</h4>
                              </div>
                            </div>
                            <div class="card__footer">
                              <a href="">View all</a>
                            </div>
                          </div>';

      // préparation retour Ajax
      $query = $pdo->query('SELECT * FROM posts');

      //retour ajax table
      $result['resultat'] = '<table>';

      $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th class="dnone">pics_id</th>
                        <th>Img</th>
                        <th>Titre</th>
                        <th>Cat</th>
                        <th>Clics</th>
                        <th>Vues</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= ' <th>Publié</th>';
                          $result['resultat'] .= '<th>Actions</th>';
                        }else{
                          $result['resultat'] .= '<th>Action</th>';
                        }
                        
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($post = $query->fetch()){

        $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$post['id_post'].'</td>';
        $result['resultat'] .= '<td class="dnone">'.$post['pics_id'].'</td>';

        if($post["pics_id"] != NULL){
          $result['resultat'] .= '<td><div class="img-profil" style="background-image: url(../global/uploads/'.getImg($pdo, $post["pics_id"]).'")"></div></td>';
        }else{
          $result['resultat'] .= '<td> </td>';
        }

        $result['resultat'] .= '<td>'.$post['titre'].'</td>';
        $result['resultat'] .= '<td><div class="td-cat">'.getIcon($pdo, $post["categories_id"]).'</div></td>';
        $result['resultat'] .= '<td>0</td>';
        $result['resultat'] .= '<td>0</td>';

        if($Membre['statut'] == 0){

          if($post['est_publie'] == 1){

            $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].' checked></td>';

          }else{

            $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].'></td>';

          }
          
          
          $result['resultat'] .= '<td class="member_action">';
              $result['resultat'] .= '<a href='.$post['url'].' class="linkbtn"></a>';
              $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$post['id_post'].'"></input>';
              $result['resultat'] .= '<input type="button" class="editbtn" id="'.$post['id_post'].'"></input>';
              $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
          $result['resultat'] .= '</td>';

          }else{

            $result['resultat'] .= '<td class="member_action">';
              $result['resultat'] .= '<a href='.$post['url'].' class="linkbtn"></a>';
            $result['resultat'] .= '</td>';

          }

        $result['resultat'] .= '</tr>';


      }

      $result['resultat'] .= '</tbody>';

      $result['resultat'] .= '</table>';

    

  }// fin else


}// fin if global

// Return result 
echo json_encode($result);
?>