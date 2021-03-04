<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/team_functions.php';

/* #############################################################################

vue du modal update a partir pteam.php en Ajax

############################################################################# */

if(isset($_POST['team_id'])){

    $result = '';
    $id = $_POST['team_id'];
    
    $query = $pdo->query("SELECT * FROM team WHERE id_team_member = '$id'");
    
    $result .= '<form action="" method="post" id="update_member" enctype="multipart/form-data">';

        while($member = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$member['id_team_member'].'">';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label class="" for="civilite">Civilité :</label>';
            $result .= '<select class="form-select" name="update_civilite" aria-label="">';
              $result .= '<option value="'.$member['civilite'].'">'.getSex($pdo, $member['civilite']).'</option>';
              $result .= '<option value="'. FEMME .'">Madame</option>';
              $result .= ' <option value="'. HOMME .'">Monsieur</option>';
              $result .= ' <option value="'. AUTRE .'">Autre</option>';
            $result .= '</select>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_username">Username : </label>';
            $result .= '<input type="text"  class="form-control" name="update_username" id="update_username" value="'.$member['username'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_name">Nom : </label>';
            $result .= '<input type="text"  class="form-control" name="update_name" id="update_name" value="'.$member['nom'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_prenom">Prénom : </label>';
            $result .= '<input type="text"  class="form-control" name="update_prenom" id="update_prenom" value="'.$member['prenom'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_email">Email : </label>';
            $result .= '<input type="email"  class="form-control" name="update_email" id="update_email" value="'.$member['email'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label class="" for="statut">Statut :</label>';
            $result .= '<select class="form-select" name="update_statut" aria-label="">';
              $result .= '<option value="'.$member['statut'].'">'.getStatut($pdo, $member['statut']).'</option>';
              $result .= '<option value="'. ROLE_ADMIN .'">Admin</option>';
              $result .= ' <option value="'. ROLE_USER .'">User</option>';
              $result .= ' <option value="'. ROLE_EDITEUR .'">Editeur</option>';
            $result .= '</select>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label class="" for="statut">Confirmation :</label>';
            $result .= '<select class="form-select" name="update_confirme" aria-label="">';
              $result .= '<option value="'.$member['confirmation'].'">'.getConfirm($pdo, $member['confirmation']).'</option>';
              $result .= '<option value="'. CONFIRME  .'">OUI</option>';
              $result .= ' <option value="'. NON_CONFIRME .'">NON</option>';
            $result .= '</select>';
        $result .= '</div>';


    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_team" id="UpdateTeamBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>