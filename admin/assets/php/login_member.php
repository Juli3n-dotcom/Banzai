<?php
require_once __DIR__ . '/../config/bootstrap_admin.php';

if(isset($_POST['login'])){

    if(empty($_POST['username'] )){
         ajouterFlash('warning','pseudo manquant');
         header('location: ../../login_admin.php');
    } elseif(empty($_POST['password'])){
         ajouterFlash('warning','mot de passe manquant');
         header('location: ../../login_admin.php');
    }else{
            $req = $pdo->prepare(
                                    'SELECT *
                                    FROM team
                                    WHERE username = :username
                                    OR email = :email'
                                );

            $req->bindParam(':username', $_POST['username']);
            $req->bindParam(':email', $_POST['username']);
            $req->execute();
            $tmember = $req->fetch(PDO::FETCH_ASSOC);

        if(!$tmember){

        ajouterFlash('error','Membre inconnue');
        header('location: ../../login_admin.php');

        }elseif(!$tmember['confirmation']){

        ajouterFlash('info','merci de confirmer votre compte');
        header('location: ../../login_admin.php');

        }elseif(!password_verify($_POST['password'], $tmember['password'])){

        ajouterFlash('error','Mot de passe erroné');
        header('location: ../../login_admin.php');

        }else{

        $_SESSION['team'] = $tmember;
        unset($_POST);
        session_write_close();
        header('Location: ../../index_admin.php');
        ajouterFlash('success','Bonjour');

        }
    }
    
}