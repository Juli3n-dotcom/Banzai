<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue d'une categorie a partir langage.php en Ajax

############################################################################# */

if(isset($_POST['lang_id'])){

    $result = '';
    $id = $_POST['lang_id'];
    
    $query = $pdo->query("SELECT * FROM langages WHERE id_langage = '$id'");
    
    $result .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
    while($lang = $query->fetch()){

        $result .= '  
                <tr>  
                     <td width="30%"><label>ID</label></td>  
                     <td width="70%">'.$lang["id_langage"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Logo :</label></td>  
                     <td width="70%"><img class="img-logo" src="../global/uploads/'. getImg($pdo, $lang['pics_id']).'"></td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Titre :</label></td>  
                     <td width="70%">'.$lang["titre"].'</td>  
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