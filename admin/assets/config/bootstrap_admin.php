<?php

 require_once __DIR__ .'/../../../global/config/bootstrap.php';

 require_once __DIR__ . '/../functions/auth.php';

 require_once __DIR__ . '/functions_global_admin.php';

 

// if(!stripos($_SERVER['REQUEST_URI'], 'login_admin.php')){
//     $Membre = getMembre($pdo, $_GET['id_team_member'] ?? null);

//     if($Membre === null){
//         ajouterFlash('error','Merci de vous connecter');
//         header('Location: login_admin.php');
//         exit();
//         }
// }