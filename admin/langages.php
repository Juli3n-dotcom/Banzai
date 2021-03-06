<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/langages_functions.php';


$page_title ='Langages';
include __DIR__. '/assets/includes/header_admin.php';

?>

<div id="notif"></div>


<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Tous les languages </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_lang_modal">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="lang_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Titre</th>
                <th>%</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Actions</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getLang($pdo) as $lang): ?>
                
                <tr>
                    <td><?=$lang['id_langage']?></td>
                    <td><div class='img-logo'><i class="<?=$lang['icone']?>"></i></div></td>

                    <td><?=$lang['titre']?></td>
                    <td><?=$lang['number']?> %</td>
                    
                    <?php if($Membre['statut'] == 0) :?>
                    <td class="member_action">
                         
                          <input type="button" class="viewbtn" name="view" id="<?=$lang['id_langage']?>"></input>
                          <input type="button" class="editbtn" id="<?=$lang['id_langage']?>"></input>
                          <input type="button" class="deletebtn"></input>
                          
                    </td>
                    <?php endif;?>
                </tr>

                <?php endforeach;?>
          </tbody>

        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> 
  </div> 

<?php if($Membre['statut'] == 0) :?>
  <!-- ############################################## ***** Modal add langage ***** ########################################################## -->

<div class="modal fade" id="addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un langage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_lang">

            <div class="mb-3">
              <label for="add_name_member">Nom du langage : </label>
              <input type="text" 
              name="add_name_lang" 
              id="add_name_lang" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="add_logo">Logo : </label>
              <input type="text" 
              name="add_logo" 
              id="add_logo" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="skillRange" class="form-label">Pourcentage : </label>
              <input type="text" id="rangeReturn" value="" class="prctVal">
              <input type="range" class="form-range" min="0" max="100" step="0.5" id="skillRange" name="skillRange">
            </div>


            
            <div class="modal-footer">
              <button type="submit" name="add_lang" id="addlangBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal edit language ***** ########################################################## -->

 
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Modifier Langage</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body" id="update_modal">
          <form action="" method="post" id="update_lang" enctype="multipart/form-data">

          

            <div class="modal-footer">
              <button type="submit" name="update_lang" id="UpdatelangBtn" class="updateBtn">Modifier</button>
            </div>
          </form>
       </div>
     </div>
   </div>
 </div>
 
 
 
 <!-- ############################################## ***** Modal delete langage ***** ########################################################## -->
 
 
 <div class="modal fade" id="deletemodal" >
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Langage</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="post" id="delete_lang">
           <input type="hidden" name="delete_id" id="delete_id">
           <input type="hidden" name="delete_img" id="delete_img">
             
           <p>Etes vous sur de vouloir supprimer ce langage?</p>
 
           <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deletecat"  id="deletecat" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
           </form>
       </div>
     </div>
   </div>
 </div>


 <!-- ############################################## ***** Modal view langage ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Langage détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="lang_detail">
        <div class="list_container">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="closeBtn" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>



<?php endif;?>

<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>