<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/categories_functions.php';


/* #############################################################################

Ajout d'une categorie a partir categories.php en Ajax

############################################################################# */


$result = array();

if(!empty($_POST)){

    $titre = $_POST['add_name_cat'];
    $word = $_POST['add_word_cat'];
    $icone = $_POST['add_logo'];
   

    if(getCatBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups cette catégorie existe déjà'); 

    }elseif(empty($icone)){

      $result['status'] = false;
      $result['notif'] = notif('error','oups!  il manque le logo'); 
  
    }else{


      $req = $pdo->prepare('INSERT INTO categories(titre, motscles, icone) VALUES (:name, :motscles, :icone)');
        
            $req->bindParam(':name',$titre);
            $req->bindParam(':motscles',$word);
            $req->bindValue(':icone',$icone);
            $req->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Nouvelle categorie ajoutée');

    $query = $pdo->query('SELECT * FROM categories');

     //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>Mots Clés</th>
                        <th>N° Site</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($cat = $query->fetch()){

      $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$cat['id_categorie'].'</td>';
        $result['resultat'] .= '<td><div class="img-logo"><i class="'.$cat['icone'].'"></i></div></td>';
        $result['resultat'] .= '<td>'.$cat['titre'].'</td>';
        $result['resultat'] .= '<td>'.$cat['motscles'].'</td>';
        $result['resultat'] .= '<td>'.getPostbyCar($pdo, $cat['id_categorie'] ).'</td>';

        if($Membre['statut'] == 0){
        $result['resultat'] .= '<td class="member_action">';
            $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$cat['id_categorie'].'"></input>';
            $result['resultat'] .= '<input type="button" class="editbtn" id="'.$cat['id_categorie'].'"></input>';
            $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
        $result['resultat'] .= '</td>';
        }

        $result['resultat'] .= '</tr>';

      }

      $result['resultat'] .= '</tbody>';

      $result['resultat'] .= '</table>';

    }
       
}

// Return result 
echo json_encode($result);

?>