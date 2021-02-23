<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir langage.php en Ajax

############################################################################# */

if(isset($_POST['lang_id'])){

    $result = '';
    $id = $_POST['lang_id'];
    
    $query = $pdo->query("SELECT * FROM langages WHERE id_langage = '$id'");
    
    $result .= '<form action="" method="post" id="update_lang" enctype="multipart/form-data">';

        while($lang = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$lang['id_langage'].'">';
        $result .= '<input type="hidden" name="update_img" id="update_img" value="'.$lang['pics_id'].'">';

        $result .= '<img src="../global/uploads/'. getImg($pdo, $lang['pics_id']).'" alt="logo" class="img-logo" id="img-logo">';

            $result .= '<span class="hiddenFileInput">';
                $result .= '<input type="file" name="new_logo" id="new_logo">';
            $result .= '</span>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name_lang">Nom du langage: </label>';
            $result .= '<input type="text"  class="form-control" name="update_name_lang" id="update_name_lang" value="'.$lang['titre'].'">';
        $result .= '</div>';
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_lang" id="UpdatelangBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>