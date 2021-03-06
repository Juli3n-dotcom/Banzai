<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/langages_functions.php';


/* #############################################################################

Ajout d'un langage a partir langage.php en Ajax

############################################################################# */


$result = array(); 

// If form is submitted 
if(!empty($_POST)){ 

  $titre = $_POST['add_name_lang'];
  $number = $_POST['skillRange'];
  $icone = $_POST['add_logo'];

  if(getLangBy($pdo,'titre',$titre)!==null){

    $result['status'] = false;
    $result['notif'] = notif('error','oups! ce langage existe déjà'); 
  
  }elseif(empty($icone)){

    $result['status'] = false;
    $result['notif'] = notif('error','oups!  il manque le logo'); 

  }else{

      
      $req = $pdo->prepare('INSERT INTO langages(titre, icone, number) VALUES (:name,:icone, :number)');
        
            $req->bindParam(':name',$titre);
            $req->bindValue(':icone',$icone);
            $req->bindValue(':number',$number);
            $req->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Nouveau langage ajouté');

    $query = $pdo->query('SELECT * FROM langages');

     //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>%</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($lang = $query->fetch()){

      $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$lang['id_langage'].'</td>';
        $result['resultat'] .= '<td><div class="img-logo"><i class="'.$lang['icone'].'"></i></div></td>';
        $result['resultat'] .= '<td>'.$lang['titre'].'</td>';
        $result['resultat'] .= '<td>'.$lang['number'].' %</td>';

        if($Membre['statut'] == 0){
        $result['resultat'] .= '<td class="member_action">';
            $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$lang['id_langage'].'"></input>';
            $result['resultat'] .= '<input type="button" class="editbtn" id="'.$lang['id_langage'].'"></input>';
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