<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue d'une categorie a partir categorie.php en Ajax

############################################################################# */

if(isset($_POST['cat_id'])){

    $result = '';
    $id = $_POST['cat_id'];
    
    $query = $pdo->query("SELECT * FROM categories WHERE id_categorie = '$id'");
    
    $result .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
    while($cat = $query->fetch()){

     $result .= '  
     <tr>  
          <td width="30%"><label>ID</label></td>  
          <td width="70%">'.$cat["id_categorie"].'</td>  
     </tr>
     <tr>  
          <td width="30%"><label>Logo :</label></td>  
          <td width="70%"><div class="img-logo"><i class="'.$cat['icone'].'"></i></div></td>  
     </tr> 
     <tr>  
          <td width="30%"><label>Titre :</label></td>  
          <td width="70%">'.$cat["titre"].'</td>  
     </tr> 
     <tr>  
          <td width="30%"><label>Mots cles :</label></td>  
          <td width="70%">'.$cat["motscles"].'</td>  
     </tr>   
     <tr>  
          <td width="30%"><label>Nombre de sites</label></td>  
          <td width="70%">0</td>  
     </tr>  
     ';  

    }

    $result .= "</table></div>"; 

    echo $result;

    
}

?>