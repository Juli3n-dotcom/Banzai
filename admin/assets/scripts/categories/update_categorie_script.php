<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/categories_functions.php';

/* #############################################################################

Modification d'une categorie a partir categorie.php en Ajax

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_name_cat'];
  $word = $_POST['update_word_cat'];
  $icone = $_POST['new_logo'];

  $data = $pdo->query("SELECT * FROM categories WHERE id_categorie = '$id'");
  $thisCat = $data->fetch(PDO::FETCH_ASSOC);

  if($titre !== $thisCat['titre']){

    if(getCatBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('warning','Ce titre est deja utilisé'); 

    }else{

    
    $req_update_cat = $pdo->prepare('UPDATE categories SET titre = :titre, motscles = :motscles, icone = :icone WHERE id_categorie = :id');

    $req_update_cat->bindParam(':id',$id,PDO::PARAM_INT);
    $req_update_cat->bindValue(':titre',$titre);
    $req_update_cat->bindValue(':motscles',$word);
    $req_update_cat->bindValue(':icone',$icone);
    $req_update_cat->execute();


    $result['status'] = true;
    $result['notif'] = notif('success','Categorie modifiée');

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

}

// Return result 
echo json_encode($result);


?>