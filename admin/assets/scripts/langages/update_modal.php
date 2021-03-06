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

        $result .= '<div class="img-logo"><i class="'.$lang['icone'].'"></i></div>';

        $result .= '<span class="hiddenFileInput plus" id="changeIcone">';
            $result .= '<input type="button" >';
        $result .= '</span>';

        $result .= '<div class="mb-3 mt-4 dnone" id="div_new_logo">';
          $result .= '<label for="update_name_cat">Nouveau Logo : </label>';
          $result .= '<input type="text"  class="form-control" name="new_logo" id="new_logo" value="'.$lang['icone'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name_lang">Nom du langage: </label>';
            $result .= '<input type="text"  class="form-control" name="update_name_lang" id="update_name_lang" value="'.$lang['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="skillRange" class="form-label">Pourcentage : </label>';
            $result .= '<input type="text" id="UpdaterangeReturn" value="'.$lang['number'].' %" class="prctVal"> ';
            $result .= '<input type="range" class="form-range" min="0" max="100" step="0.5" id="UpdateskillRange" name="UpdateskillRange" value="'.$lang['number'].'">';
        $result .= '</div>';
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_lang" id="UpdatelangBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>