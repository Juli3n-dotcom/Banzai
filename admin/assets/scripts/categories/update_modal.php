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

        $result .= '<div class="img-logo"><i class="'.$cat['icone'].'"></i></div>';

            $result .= '<span class="hiddenFileInput plus" id="changeIcone">';
                $result .= '<input type="button" >';
            $result .= '</span>';
        
        $result .= '<div class="mb-3 mt-4 dnone" id="div_new_logo">';
          $result .= '<label for="update_name_cat">Nouveau Logo : </label>';
          $result .= '<input type="text"  class="form-control" name="new_logo" id="new_logo" value="'.$cat['icone'].'">';
        $result .= '</div>';

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