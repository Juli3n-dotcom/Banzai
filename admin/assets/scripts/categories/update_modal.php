<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir categories.php en Ajax

############################################################################# */

if(isset($_POST['cat_id'])){

    $result = '';
    $id = $_POST['cat_id'];
    
    $query = $pdo->query("SELECT * FROM categories WHERE id_categorie = '$id'");
    
    $result .= '<form action="" method="post" id="update_cat" enctype="multipart/form-data">';

        while($cat = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$cat['id_categorie'].'">';
        $result .= '<input type="hidden" name="update_img" id="update_img" value="'.$cat['pics_id'].'">';

        $result .= '<img src="../global/uploads/'. getImg($pdo, $cat['pics_id']).'" alt="logo" class="img-logo" id="img-logo">';

            $result .= '<span class="hiddenFileInput">';
                $result .= '<input type="file" name="new_logo" id="new_logo">';
            $result .= '</span>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name_cat">Nom de la categorie : </label>';
            $result .= '<input type="text"  class="form-control" name="update_name_cat" id="update_name_cat" value="'.$cat['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_word_cat">Mots clés : </label>';
            $result .= '<input type="text"  class="form-control" name="update_word_cat" id="update_word_cat" value="'.$cat['motscles'].'">';
        $result .= '</div>';
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_cat" id="UpdateCatBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>