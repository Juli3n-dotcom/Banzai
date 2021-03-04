<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/team_functions.php';


$page_title ='Team';
include __DIR__. '/assets/includes/header_admin.php';
?>

<?php include __DIR__.'/../global/includes/flash.php';?>

<div class="notif" id='notif'></div>

<section>
  <div class="dash__cards" id="cards">

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-shield"></i>
        <div>
          <h5>Admin</h5>
          <h4><?= countAdmin($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="all_admin" id="all_admin" value="View all">
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user"></i>
        <div>
          <h5>User</h5>
          <h4><?= countUser($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="all_user" id="all_user" value="View all">
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-edit"></i>
        <div>
          <h5>Editeur</h5>
          <h4><?= countEditeur($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="all_editeur" id="all_editeur" value="View all">
      </div>
    </div>

  </div>
</section>


<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>All Team </h3>
            
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_team_member">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="team_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th class="dnone">Civilité</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Photo</th>
                <th>Email</th>
                <th>Status</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Confirmation</th>
                <th>Actions</th>
                <?php else:?>
                <th>Action</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getMember($pdo) as $member): ?>
                <?php
                // changement format date
                $date = str_replace('/', '-', $member['date_enregistrement']);
                $last_date = str_replace('/', '-', $member['last_login']);

                ?>
                <tr>
                    <td><?=$member['id_team_member']?></td>
                    <td class="dnone"><?=$member['civilite']?></td>
                    <td><?=$member['nom']?></td>
                    <td><?=$member['prenom']?></td>
                    <td class="td-team">
                        <?php
                          if ($member['photo_id'] == NULL) {
                            if($member['civilite'] == 0) {
                              echo "<div class='img-profil' style='background-image: url(assets/img/male.svg)'></div>";
                              }elseif($member['civilite'] == 1){
                              echo "<div class='img-profil' style='background-image: url(assets/img/female.svg)'></div>";
                            }else{
                              echo "<div class='img-profil' style='background-image: url(assets/img/profil.svg)'></div>";
                            }
                          }else{

                            //récupération de la photo de profil
                            $id_photo = $member['photo_id'];
                            $data = $pdo->query("SELECT * FROM photo WHERE id_photo = '$id_photo'");
                            $photo = $data->fetch(PDO::FETCH_ASSOC);

                            echo "<div class='img-profil' style='background-image: url(assets/uploads/" .getPhoto($pdo, $member['photo_id']). " )'></div>";
                          }
                        ?>
                    </td>
                     <td><a href="mailto:<?=$member['email']?>" class="email_member"><?=$member['email']?></a></td>
                     <td class="dnone"><i><?=$member['statut']?></i></td><!--  object non visible pour récupérétion-->
                    <td>
                      <?php if($member['statut'] == 0){
                        echo '<p class="badge admin">Admin</p>';
                      }else if($member['statut'] == 1){
                        echo '<p class="badge user">User</p>';
                      }else{
                        echo '<p class="badge editer">Editeur</p>';
                      }
                      ?>
                    </td>
                    <?php if($Membre['statut'] == 0) :?>
                     <td class="dnone"><i><?=$member['confirmation']?></i></td><!--  object non visible pour récupérétion-->
                    <td>
                      <?php if($member['confirmation'] == 0){
                        echo '<p class="badge danger confirmation">Non</p>';
                      }else{
                        echo '<p class="badge success confirmation">Oui</p>';
                      }
                      ?>
                    </td>
                    <?php endif;?>
                    <!-- <td><?= date('d-m-Y', strtotime($date))?> </td> -->
                    <td class="member_action">
                    <input type="button" class="viewbtn" name="view" id="<?=$member['id_team_member']?>"></input>

                        <?php if($Membre['statut'] == 0) :?>
                          
                          <input type="button" class="editbtn" id="<?=$member['id_team_member']?>"></input>
                          <input type="button" class="deletebtn"></input>
                        <?php endif;?>
                        
                    </td>
                </tr>


                
            <?php endforeach;?>
          </tbody>


        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> <!-- fin div team card -->
  </div> <!-- fin div team grid -->


</section>

<div class="reset" id="reset">
  
</div>

<!-- ############################################## ***** Modal add team member ***** ########################################################## -->
<?php if($Membre['statut'] == 0) :?>

<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_member">

            <div class="mb-3 mt-4">
            <label class="" for="statut">Civilité :</label>
                <select class="custom-select" name="add_civilite" id="add_civilite">
                        <option>...</option>
                        <option value="<?= FEMME ?>">Madame</option>
                        <option value="<?= HOMME ?>">Monsieur</option>
                        <option value="<?= AUTRE ?>">Autre</option>
                </select>
            </div>

            <div class="mb-3 mt-4">
              <label for="add_name_member">Nom: </label>
              <input type="text" name="add_name_member" id="add_name_member" class="form-control">
            </div>
            
            <div class="mb-3 mt-4">
              <label for="add_prenom_member">Prenom: </label>
              <input type="text" name="add_prenom_member" id="add_prenom_member" class="form-control">
            </div>
            
            <div class="mb-3 mt-4">
              <label for="add_email_member">Email: </label>
              <input type="email" name="add_email_member" id="add_email_member" class="form-control">
            </div>
            

          <div class="mb-3 mt-4">
            <label class="" for="add_statut">Statut :</label>
                <select class="custom-select" name="add_statut" id="add_statut">
                        <option>...</option>
                        <option value="<?= ROLE_ADMIN ?>">Admin</option>
                        <option value="<?= ROLE_USER ?>">User</option>
                        <option value="<?= ROLE_EDITEUR ?>">Editeur</option>
                </select>
            </div>


            <div class="modal-footer">
              <button type="submit" name="add_team_member" class="addBtn">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- ############################################## ***** Modal delete team member ***** ########################################################## -->


<div class="modal fade" id="deletemodal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="delete_member">
          <input type="hidden" name="delete_id" id="delete_id">
            
          <p>Etes vous sur de vouloir supprimer cette personne?</p>

          <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deletemember"  id="deletemember" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
          </form>
      </div>
    </div>
  </div>
</div>



<!-- ############################################## ***** Modal edit team member ***** ########################################################## -->

 
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="update_modal">
        
      </div>
    </div>
  </div>
</div>


<?php endif ;?>

<!-- ############################################## ***** Modal view member ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Member détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="member_detail">
        <div class="list_container">
          
      </div>
    </div>
  </div>
</div>

<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>