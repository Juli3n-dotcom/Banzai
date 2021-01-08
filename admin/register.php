<?php
require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/team_functions.php';

$page_title ='Register';
include __DIR__. '/assets/includes/header_admin.php';
?>

<div class="register__container">
    
    <form action="assets/php/register_member.php" class="form" id="form" method="post">
        <div class="register-title">
            <h2>Ajouter un membre</h2>
        </div>

        <div class="container__form">

        <div class="form-control">
            <label class="" for="statut">Civilité :</label>
                <select class="form-select" name="add_civilite" id="add_civilite">
                        <option>...</option>
                        <option value="<?= FEMME ?>">Madame</option>
                        <option value="<?= HOMME ?>">Monsieur</option>
                        <option value="<?= AUTRE ?>">Autre</option>
                </select>
            </div>

            <div class="form-control ">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="add_name_member" >
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>

            <div class="form-control">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="add_prenom_member">
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
                <label for="email">Email :</label>
                <input type="email" id="email" name="add_email_member">
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
                <label for="password">Password :</label>
                <input type="password" id="password" name="password">
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
                <label for="confirme">Confirme password :</label>
                <input type="password" id="confirme" name="confirm">
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
            <label class="" for="update_statut">Statut :</label>
                <select class="form-select" name="add_statut" id="add_statut">
                        <option>...</option>
                        <option value="<?= ROLE_ADMIN ?>">Admin</option>
                        <option value="<?= ROLE_USER ?>">User</option>
                        <option value="<?= ROLE_EDITEUR ?>">Editeur</option>
                </select>
            </div>

            <div class="modal-footer">
              <button type="submit" name="add_team_member" id="addmember"class="addBtn">Valider</button>
            </div>

        </div>

    </form>
</div>

<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>