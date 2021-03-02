<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/categories_functions.php';


$page_title ='Catégories';
include __DIR__. '/assets/includes/header_admin.php';

?>

<div id="notif"></div>

<section>
  <div class="dash__cards">

  <?php foreach(getCatOrder($pdo) as $cat): ?>

    <div class="card__single">
      <div class="card__body">
      <div class='img-logo' style='background-image: url(../global/uploads/<?=getImg($pdo, $cat['pics_id'])?>)'></div>
        <div>
          <h5><?= $cat['titre']?></h5>
          <h4><?= getPostbyCar($pdo, $cat['id_categorie'] )?></h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="">View all</a>
      </div>
    </div>

  <?php endforeach;?>

    

  </div>
</section>


<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Toutes les catégories </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_cat_modal">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="categories_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th class="dnone">pics_id</th>
                <th>Logo</th>
                <th>Titre</th>
                <th>Mots Clés</th>
                <th>N° Site</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Actions</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getCat($pdo) as $cat): ?>
                
                <tr>
                    <td><?=$cat['id_categorie']?></td>
                    <td class="dnone"><?=$cat['pics_id']?></td>
                    <?php if($cat["pics_id"] !== NULL){
                      echo "<td><div class='img-logo' style='background-image: url(../global/uploads/". getImg($pdo, $cat['pics_id']).")'></div></td>";
                    }else{
                      echo "<td></td>";
                    }
                    ?>  
                    <td><?=$cat['titre']?></td>
                    <td><?=$cat['motscles']?></td>
                    <td><?= getPostbyCar($pdo, $cat['id_categorie'] )?></td>
                    
                    <?php if($Membre['statut'] == 0) :?>
                    <td class="member_action">
                         
                          <input type="button" class="viewbtn" name="view" id="<?=$cat['id_categorie']?>"></input>
                          <input type="button" class="editbtn" id="<?=$cat['id_categorie']?>"></input>
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
  <!-- ############################################## ***** Modal add cat ***** ########################################################## -->

<div class="modal fade" id="addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une categorie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_cat">

            <div class="mb-3">
              <label for="add_name_member" class="form_label">Nom de la catégorie: </label>
              <input type="text" 
              name="add_name_cat" 
              id="add_name_cat" 
              class="form-control">
            </div>
            
            
            <div class="mb-3">
              <label for="add_email_member" class="form_label">Mots Clés: </label>
              <input type="text" name="add_word_cat" id="add_word_cat" class="form-control">
            </div>

            <div class="mb-3">
              <label for="add_logo" class="form_label">Logo : </label>
              <input type="file" 
              name="add_logo" 
              id="add_logo" 
              class="form-control">
            </div>
            

            <div class="modal-footer">
              <button type="submit" name="add_cat" id="addCatBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal edit Cat ***** ########################################################## -->

 
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Modifier Categorie</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body" id="update_modal">
          <form action="" method="post" id="update_cat" enctype="multipart/form-data">

           


            <div class="modal-footer">
              <button type="submit" name="update_cat" id="UpdateCatBtn" class="updateBtn">Modifier</button>
            </div>
          </form>
       </div>
     </div>
   </div>
 </div>
 
 
 
 <!-- ############################################## ***** Modal delete Cat ***** ########################################################## -->
 
 
 <div class="modal fade" id="deletemodal" >
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Categorie</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="post" id="delete_cat">
           <input type="hidden" name="delete_id" id="delete_id">
           <input type="hidden" name="delete_img" id="delete_img">
             
           <p>Etes vous sur de vouloir supprimer cette categorie?</p>
 
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


 <!-- ############################################## ***** Modal view cat ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Catégories détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="cat_detail">
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