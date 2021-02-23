<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/posts_functions.php';
require_once __DIR__ . '/../../functions/categories_functions.php';

/* #############################################################################

vue du modal update a partir posts.php en Ajax

############################################################################# */

if(isset($_POST['post_id'])){

    $result = '';
    $id = $_POST['post_id'];
    
    $query = $pdo->query("SELECT * FROM posts WHERE id_post = '$id'");
    
    $result .= '<form action="" method="post" id="update_post" enctype="multipart/form-data">';

        while($post = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$post['id_post'].'">';
        $result .= '<input type="hidden" name="update_img" id="update_img" value="'.$post['pics_id'].'">';

        $result .= '<img src="../global/uploads/'. getImg($pdo, $post['pics_id']).'" alt="logo" class="img-logo" id="img-logo">';

            $result .= '<span class="hiddenFileInput">';
                $result .= '<input type="file" name="new_logo" id="new_logo">';
            $result .= '</span>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name_post">titre du post : </label>';
            $result .= '<input type="text"  class="form-control" name="update_name_post" id="update_name_post" value="'.$post['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_contenu">Contenu : </label>';
            $result .= '<textarea class="form-control" id="update_contenu" name="update_contenu">'.$post['contenu'].'</textarea>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name_post">Url : </label>';
            $result .= '<input type="text"  class="form-control" name="update_url_post" id="update_url_post" value="'.$post['url'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="cat" class="form_label">Changer de catégorie : </label>';
            $result .= '<select class="form-select" name="cat" aria-label="">';
                $result .= '<option value="'.getActualCatID($pdo,$post['categories_id']).'">'.getActualCatTitle($pdo,$post['categories_id']).'</option>';
                foreach(getOtherCat($pdo,$post['categories_id']) as $cat){
                    $result .= ' <option value="'.$cat['id_categorie'].'">'.$cat['titre'].'</option>';
                }

            $result .= '</select>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="est publié" class="form_label">Publié : </label>';
            if($post['est_publie'] == 1){
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].' checked></td>';
            }else{
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value='.$post['est_publie'].'></td>';
            }
        $result .= '</div>';


    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_post" id="UpdatePostBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>