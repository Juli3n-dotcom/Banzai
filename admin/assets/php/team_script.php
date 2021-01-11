<?php
require_once __DIR__ . '/../config/bootstrap_admin.php';
require_once __DIR__ . '/../functions/team_functions.php';

/* #############################################################################

Update a partir update_profil.php

# Modification des informations de l'utilisateur

## suppresion de la photo de profil

############################################################################# */

if(isset($_POST['update'])){

    $id = $_POST['id_membre'];
    $email = $_POST['email'];
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $fname= htmlspecialchars($_POST['fname']);
    $mdp = $_POST['password'];
    $id_photo = '';
    
    $data = $pdo->query("SELECT * FROM team WHERE id_team_member = '$id'");
    $Membre = $data->fetch(PDO::FETCH_ASSOC);

    // debut de la requete d'update
    $param = FALSE;
    $requete = 'UPDATE team SET ';

    if($email !== $Membre['email']){

        if(getMemberBy($pdo, 'email', $email)!==null) {
            ajouterFlash('error','Email déja utilisé !');
            header('location: ../../update_profil.php');

        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ajouterFlash('error','Email non valide.');
            header('location: ../../update_profil.php');
        }else{
            $requete .= 'email = :email';
            $param = TRUE;   
        }
    }

    if($username !== $Membre['username']){
        
        if(getMemberBy($pdo, 'username', $username)!== null) {
            ajouterFlash('error','Pseudo déja utilisé !');
            header('location: ../../update_profil.php');

        }elseif(!preg_match('~^[a-zA-Z0-9-]+$~',$username)) {
            ajouterFlash('error','Merci d\'utiliser uniquement des minuscules, majuscules et chiffre de 0 a 9');
            header('location: ../../update_profil.php');
        }else{
            if($param == true){
                $requete .= ', username = :username';
            }else{
                $requete .= 'username = :username';
            }
            $param = TRUE;   
        }
    }

    if($name !== $Membre['nom']){

        if(!preg_match('~^[a-zA-Z-]+$~',$name)){
            ajouterFlash('error','nom manquant');
            header('location: ../../update_profil.php');
        }else{
             if($param == true){
                $requete .= ', nom = :nom';
            }else{
                $requete .= 'nom = :nom';
            }
            $param = TRUE;   
        }
    }

    if($fname !== $Membre['prenom']){

        if(!preg_match('~^[a-zA-Z-]+$~',$fname)){
            ajouterFlash('error','nom manquant');
            header('location: ../../update_profil.php');
        }else{
             if($param == true){
                $requete .= ', prenom = :prenom';
            }else{
                $requete .= 'prenom = :prenom';
            }
            $param = TRUE;  
        }
    }
    
    if(!empty($mdp)){

        if(!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~',$mdp)) {
            ajouterFlash('error','Votre mot de passe doit contenir :minimum 8 caractéres, 1 maj, 1min, 1chiffre  et 1 caractére spécial.');
            header('location: ../../update_profil.php');

        }elseif ($mdp !== $_POST['confirme'] ){
            ajouterFlash('error','Merci de confirmer votre mot de passe.');
            header('location: ../../update_profil.php');

        }else{

            if($param == true){
                $requete .= ', password = :password';
            }else{
                $requete .= 'password = :password';
            }
            $param = TRUE;  

        }
    }
        
    
    // enregistrement de la nouvelle photo de profil
    if(!empty($_FILES['avatar']['tmp_name'])){

        if($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            ajouterFlash('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['avatar']['error']);
            header('location: ../../update_profil.php');


        }elseif ($_FILES['avatar']['size']<12 || exif_imagetype($_FILES['avatar']['tmp_name'])=== false ){
          ajouterFlash('error','Le fichier envoyé n\'est pas une image');
           header('location: ../../update_profil.php');

        }else{

        $extension1 = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $path1 = __DIR__.'/../avatars';

        

        do{
             $filename1 = bin2hex(random_bytes(16));
             $complete_path1 = $path1.'/'.$filename1.'.'.$extension1;
        }while (file_exists( $complete_path1));

        }

        if(!move_uploaded_file($_FILES['avatar']['tmp_name'],$complete_path1)){
            ajouterFlash('error','La photo n\'a pas pu être enregistrée');
    
            }else{

                if($Membre['id_photo'] == NULL){

                    $req1 = $pdo->prepare(
                    'INSERT INTO photo(profil)
                         VALUES (:profil)'
                          );
                            
                $req1->bindValue('profil',$filename1.'.'.$extension1);
                $req1->execute();

                }else{
                    // suppresion de l'ancienne photo et enregistrement de la nouvelle
                    $id_photo = $Membre['photo_id'];
                    $data = $pdo->query("SELECT * FROM photo WHERE id_photo = '$id_photo'");
                    $photo = $data->fetch(PDO::FETCH_ASSOC);

                    $file = __DIR__.'/../avatars';

                    opendir($file);
                    unlink($file.$photo['profil']);
                    closedir($file);

                    $req2 = $pdo->prepare(
                        'UPDATE photo SET
                        profil = :profil
                        WHERE id_photo = :id'
                    );

                    $req2->bindParam(':id',$id,PDO::PARAM_INT);
                    $req2->bindValue('profil',$filename1.'.'.$extension1);
                    $req2->execute();

                }

                $photo = $pdo-> lastInsertId();

                if($param == true){
                    $requete .= ', photo_id = :photo_id';
                }else{
                    $requete .= 'photo_id = :photo_id';
                }

            }
        
    }

    $requete .= ' WHERE id_team_member = :id';
    

    // préparation de la requete
    $req = $pdo->prepare($requete);
    $req->bindParam(':id',$id,PDO::PARAM_INT);

    if($email !== $Membre['email']){
        $req->bindValue(':email',$email);
    }
    if($username !== $Membre['username']){
        $req->bindValue(':username',$username);
    }
    if($name !== $Membre['nom']){
        $req->bindValue(':nom',$name);
    }
    if($fname !== $Membre['prenom']){
        $req->bindValue(':prenom',$fname);
    }
    if(!empty($mdp)){
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        $req->bindValue(':password',$hash);
    }
    if(!empty($_FILES['avatar']['tmp_name'])){
        $req->bindValue(':photo_id',$photo);
    }
     
    $req->execute();

    

    ajouterFlash('success','vos informations ont bien été modifiées');
    header('location: ../../profil_admin.php');
}

//suppresion de la photo
if(isset($_POST['deleteAvatar'])){

    $id = $_POST['id_membre'];
    
    $data = $pdo->query("SELECT * FROM team WHERE id_team_member = '$id'");
    $Membre = $data->fetch(PDO::FETCH_ASSOC);

    $id_photo = $Membre['photo_id'];
    $data = $pdo->query("SELECT * FROM photo WHERE id_photo = '$id_photo'");
    $photo = $data->fetch(PDO::FETCH_ASSOC);


    $file = '../avatars/';
    $dir = opendir($file);
    unlink($file.$photo['profil']);
    closedir($dir);

    $req = $pdo->prepare(
        'DELETE FROM photo
        WHERE id_photo = :id'
    );

    $req->bindParam(':id',$id_photo,PDO::PARAM_INT);
    $req->execute();

    ajouterFlash('success','Votre photo a bien été supprimée');
    header('location: ../../profil_admin.php');
}

/* #############################################################################

Update a partir team.php (fonction uniquement ADMIN)

# Ajout d'un membre par un admin

## Modification des informations de l'utilisateur par un admin

### suppresion d'un membre de la team par un admin

############################################################################# */

// Ajout d'un membre par un admin
if(isset($_POST['add_team_member'])){
    
    if(!preg_match('~^[a-zA-Z-]+$~',$_POST['add_name_member'])){

         ajouterFlash('error','Nom manquant');
         header('location: ../../team.php');

}elseif (!preg_match('~^[a-zA-Z-]+$~',$_POST['add_prenom_member'])) {

         ajouterFlash('error','Prénom manquant');
         header('location: ../../team.php');

}elseif(getMemberBy($pdo, 'email', $_POST['add_email_member'])!==null){

         ajouterFlash('error','Email déja utilisé !');
         header('location: ../../team.php');
        
}elseif (!filter_var($_POST['add_email_member'], FILTER_VALIDATE_EMAIL)) {
       
         ajouterFlash('error','Email non valide ou manquant!');
         header('location: ../../team.php');

}else{

    
    //création d'un mot de passe aléatoire
    function passgen($nbChar) {
    $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0@#";
    srand((double)microtime()*1000000);
    $pass = '';
    for($i=0; $i<$nbChar; $i++){
        $pass .= $chaine[rand()%strlen($chaine)];
        }
    return $pass;
    }

    $mdp = passgen(8);
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    
    //création de l'username + création du name
    $first_name = $_POST['add_prenom_member'];
    $a = $first_name[0];
    $explode_name = explode(' ',$_POST['add_name_member']);
    $explode_fn = explode(' ',$_POST['add_prenom_member']);

    $username = strtolower($a.$explode_name[0]);
    $name = 'Fr'.$explode_fn[0].$explode_name[0].bin2hex(random_bytes(6));

    //autres valeurs
    $token = bin2hex(random_bytes(16));
    $civilite = $_POST['add_civilite'];
    $statut = $_POST['add_statut'];

    // requete SQL
    $req = $pdo->prepare(
            'INSERT INTO team (
                civilite,
                username,
                nom,
                prenom,
                email,
                password,
                photo_id,
                statut,
                date_enregistrement,
                confirmation,
                token,
                name
            )
            VALUES (
                :civilite,
                :username,
                :nom,
                :prenom,
                :email,
                :password,
                :photo_id,
                :statut,
                :date,
                :confirmation,
                :token,
                :name
            )'
        );

        $req->bindParam(':civilite',$civilite);
        $req->bindParam(':username',$username);
        $req->bindParam(':nom',htmlspecialchars($_POST['add_name_member']));
        $req->bindParam(':prenom',htmlspecialchars($_POST['add_prenom_member']));
        $req->bindParam(':email',$_POST['add_email_member']);
        $req->bindParam(':password',$hash);
        $req->bindValue(':photo_id',NULL);
        $req->bindValue(':statut',$statut);
        $req->bindValue(':date',(new DateTime())->format('Y-m-d H:i:s'));
        $req->bindValue(':confirmation',0);
        $req->bindParam(':token',$token);
        $req->bindParam(':name',$name);
        $req->execute();

        
        if($req){
        ajouterFlash('success','Membre Ajouté !');
        header('location: ../../team.php');
        unset($_POST); 
        }else{
        ajouterFlash('error','no member add !');
        header('location: ../../team.php');
        }
    }
}

// modification des informations de l'utilisateur 
if(isset($_POST['updatemember'])){


$req_update = $pdo->prepare(
        'UPDATE team SET
        civilite = :civilite,
        nom = :nom,
        prenom = :prenom,
        email = :email,
        statut = :statut,
        confirmation = :confirmation
        WHERE id_team_member = :id_team_member'
    );

    $req_update->bindValue(':civilite',$_POST['update_civilite']);
    $req_update->bindValue(':nom',$_POST['update_name_member']);
    $req_update->bindValue(':prenom',$_POST['update_prenom_member']);
    $req_update->bindValue(':email',$_POST['update_email_member']);
    $req_update->bindValue(':statut',$_POST['update_statut']);
    $req_update->bindValue(':confirmation',$_POST['update_confirmation']);
    $req_update->bindParam(':id_team_member',$_POST['update_id'],PDO::PARAM_INT);
    $req_update->execute();

    if($req_update){
        ajouterFlash('success','Membre modifié !');
        header('location: ../../team.php');
 
    }else{
        ajouterFlash('error','echec update !');
        header('location: ../../team.php');
    }
}

// suppresion d'un membre de la team
if(isset($_POST['deletemember'])){

    if(!isset($_POST['confirmedelete'])){
      ajouterFlash('error','Merci de confirmer la suppression !');
      header('location: ../../team.php');
  
    }else{

    $req_delete = $pdo->prepare(
        'DELETE FROM team 
        WHERE id_team_member = :id_team_member'
    );

    $req_delete->bindParam(':id_team_member',$_POST['delete_id'],PDO::PARAM_INT);
    $req_delete->execute();

    if($req_delete){
        ajouterFlash('success','Membre supprimé !');
        header('location: ../../team.php');
 
    }else{
        ajouterFlash('error','echec delete !');
        header('location: ../../team.php');
    }

    }

}

?>