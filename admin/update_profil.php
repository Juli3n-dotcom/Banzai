<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/team_functions.php';



$page_title ='Modifier mon profil';
include __DIR__. '/assets/includes/header_admin.php';
include __DIR__.'/../global/includes/flash.php';
?>

<section class="update__container">

    <form action="assets/scripts/team/team_script.php" method="POST" enctype="multipart/form-data"> 

    <input type="hidden"  name="id_membre" value="<?= $Membre['id_team_member']?>">

    <div class="profil__pics mb-3">

        <?php
            if ($Membre['photo_id'] == NULL){
                if($Membre['civilite'] == 0) {
                    echo "<img src='assets/img/male.svg' alt='photo_profil_male' class='profil-img' id='photo_profil'>";
                }elseif($Membre['civilite'] == 1){
                    echo "<img src='assets/img/female.svg' alt='photo_profil_female' class='profil-img' id='photo_profil'>";
                }else{
                    echo "<img src='assets/img/profil.svg' alt='photo_profil_other' class='profil-img' id='photo_profil'>";
                }
            }else{

                //récupération de la photo de profil
                $id_photo = $Membre['photo_id'];
                $data = $pdo->query("SELECT * FROM photo WHERE id_photo = '$id_photo'");
                $photo = $data->fetch(PDO::FETCH_ASSOC);

                    echo "<img src='assets/uploads/" .$photo['profil']. "' alt='photo_profil' class='profil-img' id='photo_profil'>";
            }
        ?>

        <span class="hiddenFileInput">
            <input type="file" name="avatar" id="avatar">
        </span>
        
            <span class="hiddenFileInput hidden__delete">
                <input type="submit" name="deleteAvatar" id="avatar">
            </span>
       
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username :</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $Membre['username'] ?>">
    </div>
    
    <div class="mb-3">
        <label for="name" class="form-label">Votre Nom :</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $Membre['nom'] ?>">
    </div>

    <div class="mb-3">
        <label for="fname" class="form-label">Votre Prénom :</label>
        <input type="text" class="form-control" id="fname" name="fname" value="<?= $Membre['prenom'] ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Votre Email :</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $Membre['email'] ?>">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe : </label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="mb-3">
        <label for="confirme" class="form-label">Confirmer votre mot de passe : </label>
        <input type="password" class="form-control" id="confirme" name="confirme">
    </div>

    <div class="update_footer">
        <input type="submit"  name="update" class="update_btn" value="Valider">
    </div>
        
    </form>
</section>


<?php
include __DIR__. '/assets/includes/footer_admin.php';
?>