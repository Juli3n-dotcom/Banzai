<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/posts_functions.php';
require_once __DIR__ . '/../../functions/categories_functions.php';

/* #############################################################################

view d'un post a partir posts.php en Ajax

############################################################################# */

if(isset($_POST['post_id'])){

  $result = '';
  $id = $_POST['post_id'];
  
  $query = $pdo->query("SELECT * FROM posts WHERE id_post = '$id'");

  $result .= '<div class="card" style="">';

  while($post = $query->fetch()){
    $result .= '<img src="../global/uploads/'. getImg($pdo, $post['pics_id']).'" class="card-img-top" alt="img">';

    $result .= '<div class="card-body">';
      $result .= '<h5 class="card-title">'.$post['titre'].'</h5>';
      // $result .= '<p class="card-text">'.$post['contenu'].'</p>';
    $result .= '</div>';

    $result .= '<div class="table-responsive">';
      $result .= '<table class="table table-bordered">';

        $result .= '<tr>  
                        <td width="40%"><label>ID : </label></td>  
                        <td width="60%">'.$post["id_post"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Contenu :</label></td>  
                        <td width="60%">'.$post["contenu"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Categorie :</label></td>  
                        <td width="60%">'.getIcon($pdo, $post["categories_id"]).'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Nombre de clics : </label></td>  
                        <td width="60%">0</td>  
                    </tr>';
        $result .= '<tr>  
                      <td width="40%"><label>Nombre de Vues : </label></td>  
                      <td width="60%">0</td>  
                    </tr>';

        if($Membre['statut'] == 0){
          $result .= '<tr>';
            $result .= '<td width="40%"><label>Publié : </label></td>  ';
            if($post['est_publie'] == 1){
            
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].' checked></td>';
            
            }else{
            
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].'></td>';
            
            }
            $result .= '</tr>';
        }


      $result .= '</table>';
    $result .= '</div>';




  }

  $result .='</div>';
  

  echo $result;

}

?>


  
    
    
  
  
   