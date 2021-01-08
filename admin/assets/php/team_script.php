<?php
require_once __DIR__ . '/../config/bootstrap_admin.php';
require_once __DIR__ . '/../functions/team_functions.php';


if(isset($_POST['update'])){

    $id = $_POST['id_membre'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $fname= $_POST['fname'];
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

?>