<?php
require_once __DIR__ . '/../config/bootstrap_admin.php';
require_once __DIR__ . '/../functions/team_functions.php';


if(isset($_POST['add_team_member'])){
    
    if(!preg_match('~^[a-zA-Z-]+$~',$_POST['add_name_member'])){

         ajouterFlash('error','Nom manquant');
         header('location: ../../register.php');

}elseif (!preg_match('~^[a-zA-Z-]+$~',$_POST['add_prenom_member'])) {

         ajouterFlash('error','Prénom manquant');
         header('location: ../../register.php');

}elseif(getMemberBy($pdo, 'email', $_POST['add_email_member'])!==null){

         ajouterFlash('error','Email déja utilisé !');
         header('location: ../../register.php');
        
}elseif (!filter_var($_POST['add_email_member'], FILTER_VALIDATE_EMAIL)) {
       
         ajouterFlash('error','Email non valide ou manquant!');
         header('location: ../../register.php');

 }elseif (!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~',$_POST['password'])) {
        ajouterFlash('danger','Votre mot de passe doit contenir :minimum 8 caractéres, 1 maj, 1min, 1chiffre  et 1 caractére spécial.');
         header('location: ../../register.php');
      
     
    }elseif ($_POST['password'] !== $_POST['confirm'] ){
        ajouterFlash('danger','Merci de confirmer votre mot de passe.');
         header('location: ../../register.php');

}else{

    
    
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
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
        header('location: ../../register.php');
        }
    }
}

?>