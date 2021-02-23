<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/team_functions.php';


$page_title ='Team';
include __DIR__. '/assets/includes/header_admin.php';
?>

<?php include __DIR__.'/../global/includes/flash.php';?>

<div class="notif"></div>

<section>
  <div class="dash__cards">

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-shield"></i>
        <div>
          <h5>Admin</h5>
          <h4><?= $admin ?></h4>
        </div>
      </div>
      <div class="card__footer">
      <a href="">View all</a>
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user"></i>
        <div>
          <h5>User</h5>
          <h4><?= $user ?></h4>
        </div>
      </div>
      <div class="card__footer">
      <a href="">View all</a>
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-user-edit"></i>
        <div>
          <h5>Editeur</h5>
          <h4><?= $editeur?></h4>
        </div>
      </div>
      <div class="card__footer">
      <a href="">View all</a>
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

        <div class="table-responsive">
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
                <?php endif;?>
                <th>Action</th>
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

                            echo "<div class='img-profil' style='background-image: url(assets/avatars/" .$photo['profil']. " )'></div>";
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
                        <a href="#" class="viewbtn" data-bs-toggle="modal" data-bs-target="#<?= $member['name'];?>"><i class="fa fa-eye"></i></a>

                        <?php if($Membre['statut'] == 0) :?>
                          <a href="#" class="editbtn"><i class="fas fa-edit"></i></a>
                          <a href="#" class="delete_team_member"><i class="fas fa-trash-alt"></i></a>
                        <?php endif;?>
                        
                    </td>
                </tr>

<!-- ############################################## ***** Modal view team member ***** ########################################################## -->
  
  
<div class="modal fade" id="<?= $member['name'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Team Member | N° <?= $member['id_team_member'] ;?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="list_container">
          <ul>
            <li>
              <h6>ID : </h6>
              <p><?= $member['id_team_member'] ;?></p>
            </li>
            <li>
              <h6>Nom : </h6>
              <p><?= $member['nom'] ;?></p>
            </li>
            <li>
              <h6>Prenom : </h6>
              <p><?= $member['prenom'] ;?></p>
            </li>
            <li>
              <h6>Email : </h6>
              <p><?= $member['email'] ;?></p>
            </li>
            <li>
              <h6>Username : </h6>
              <p><?= $member['username'] ;?></p>
            </li>
            <li>
              <h6>Status : </h6>
              <p>
                <?php if($member['statut'] == 0){
                        echo '<p class="badge admin">Admin</p>';
                      }else if($member['statut'] == 1){
                        echo '<p class="badge user">User</p>';
                      }else{
                        echo '<p class="badge editer">Editeur</p>';
                      }
                      ?>
              </p>
            </li>
            <?php if($Membre['statut'] == 0) :?>
            <li>
              <h6>Confirmation : </h6>
              <p>
                <?php if($member['confirmation'] == 0){
                        echo '<p class="badge danger confirmation">Non</p>';
                      }else{
                        echo '<p class="badge success confirmation">Oui</p>';
                      }
                      ?>
              </p>
            </li>
            <li>
              <h6>Derniére connexion : </h6>
              <p><?= date('d-m-Y', strtotime($last_date)) ;?></p>
            </li>
            <li>
              <h6>Date d'enregistrement : </h6>
              <p><?= date('d-m-Y', strtotime($date)) ;?></p>
            </li>
            <?php endif ;?>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="closeBtn" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


                
            <?php endforeach;?>
          </tbody>

          

        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> <!-- fin div team card -->
  </div> <!-- fin div team grid -->

<!-- Pagination -->
  <div class="pagination">
      <nav aria-label="...">
        <ul class="">
        <?php
            for($i=1;$i<=$pageTotales;$i++){
            if($i == $pageCourante){
                echo '<li class=" active" aria-current="page"><span class="">'.$i.'<span class="sr-only">(current)</span></span></li>';
            }else{
                echo'<li class=""><a class="" href="team.php?page='.$i.'">'.$i.'</a></li> ';
            }
            }
        ?>
      </ul>
      </nav>
  </div>

</section>

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
        <form action="assets/scripts/team/team_script.php" method="post">

            <div class="mb-3">
            <label class="" for="statut">Civilité :</label>
                <select class="custom-select" name="add_civilite" id="add_civilite">
                        <option>...</option>
                        <option value="<?= FEMME ?>">Madame</option>
                        <option value="<?= HOMME ?>">Monsieur</option>
                        <option value="<?= AUTRE ?>">Autre</option>
                </select>
            </div>

            <div class="mb-3">
              <label for="add_name_member">Nom: </label>
              <input type="text" name="add_name_member" id="add_name_member" class="form-control">
            </div>
            
            <div class="mb-3">
              <label for="add_prenom_member">Prenom: </label>
              <input type="text" name="add_prenom_member" id="add_prenom_member" class="form-control">
            </div>
            
            <div class="mb-3">
              <label for="add_email_member">Email: </label>
              <input type="email" name="add_email_member" id="add_email_member" class="form-control">
            </div>
            

          <div class="mb-3">
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
<?php endif;?>


<!-- ############################################## ***** Modal edit team member ***** ########################################################## -->
<?php if($Membre['statut'] == 0) :?>
 
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="assets/scripts/team/team_script.php" method="post">
          <input type="hidden" name="update_id" id="update_id">
            <div class="mb-3">
            <label class="" for="statut">Civilité :</label>
                <select class="custom-select" name="update_civilite" id="update_civilite">
                        <option value="<?= FEMME ?>">Madame</option>
                        <option value="<?= HOMME ?>">Monsieur</option>
                        <option value="<?= AUTRE ?>">Autre</option>
                </select>
            </div>

            <div class="mb-3">
              <label for="update_name_member">Nom: </label>
              <input type="text" name="update_name_member" id="update_name_member" class="form-control">
            </div>
            
            <div class="mb-3">
              <label for="update_prenom_member">Prenom: </label>
              <input type="text" name="update_prenom_member" id="update_prenom_member" class="form-control">
            </div>
            
            <div class="mb-3">
              <label for="email">Email: </label>
              <input type="email" name="update_email_member" id="update_email_member" class="form-control">
            </div>
            

          <div class="mb-3">
            <label class="" for="update_statut">Statut :</label>
                <select class="custom-select" name="update_statut" id="update_statut">
                        <option value="<?= ROLE_ADMIN ?>">Admin</option>
                        <option value="<?= ROLE_USER ?>">User</option>
                        <option value="<?= ROLE_EDITEUR ?>">Editeur</option>
                </select>
            </div>

            <div class="mb-3">
            <label class="" for="update_confirmation">Confirmation :</label>
                <select class="custom-select" name="update_confirmation" id="update_confirmation">
                        <option value="<?= NON_CONFIRME ?>">NON</option>
                        <option value="<?= CONFIRME ?>">OUI</option>
                </select>
            </div>

            <div class="modal-footer">
              <button type="submit" name="updatemember" class="updateBtn" >Valider</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php endif;?>


<!-- ############################################## ***** Modal delete team member ***** ########################################################## -->
<?php if($Membre['statut'] == 0) :?>

<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="assets/scripts/team/assets/php/team_script.php" method="post">
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
<?php endif ;?>

<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>