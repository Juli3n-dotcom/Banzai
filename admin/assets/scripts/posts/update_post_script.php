<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/posts_functions.php';
require_once __DIR__ . '/../../functions/categories_functions.php';

/* #############################################################################

update un post a partir posts.php en Ajax

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_name_post'];
  $contenu = $_POST['update_contenu'];
  $url = $_POST['update_url_post'];
  $cats = $_POST['cat'];

  $data = $pdo->query("SELECT * FROM posts WHERE id_post = '$id'");
  $thisPost = $data->fetch(PDO::FETCH_ASSOC);

  if($titre !== $thisPost['titre'] And getPostBy($pdo,'titre',$titre) !== null){

    $result['status'] = false;
    $result['notif'] = notif('warning','Ce titre est deja utilisé'); 
  

  }elseif($url !== $thisPost['url'] And getPostBy($pdo,'url',$url) !== null){

      $result['status'] = false;
      $result['notif'] = notif('warning','L\'Url est deja utilisée'); 

  }else{

    if(!empty($_FILES['new_logo']['tmp_name'])){

      $img = $thisPost['pics_id'];
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

    //modification du post
    $req_update_post = $pdo->prepare('UPDATE posts SET titre = :titre, 
                                                        contenu = :contenu,
                                                        url = :url,
                                                      categories_id = :categories_id,
                                                      est_publie = :publie
                                                      WHERE id_post = :id');

    $req_update_post->bindParam(':id',$id,PDO::PARAM_INT);
    $req_update_post->bindValue(':titre',$titre);
    $req_update_post->bindValue(':contenu',$contenu);
    $req_update_post->bindValue(':url',$url);
    $req_update_post->bindParam(':categories_id',$cats,PDO::PARAM_INT);
    $req_update_post->bindValue(':publie',isset($_POST['est_publie']),PDO::PARAM_BOOL);
    $req_update_post->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Post modifié');

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

    
  }

} // fin if $_POST

// Return result 
echo json_encode($result);

?>