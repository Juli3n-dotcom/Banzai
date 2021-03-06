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
                     <td width="70%"><div class="img-logo"><i class="'.$lang['icone'].'"></i></div></td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Titre :</label></td>  
                     <td width="70%">'.$lang["titre"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>% de compétences</label></td>  
                     <td width="70%">'.$lang["number"].' %</td>  
                </tr>  
                ';  

    }

    $result .= "</table></div>"; 

    echo $result;

    
}

?>