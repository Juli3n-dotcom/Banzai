<?php

// vérification si utilisateur est connecté
function getMembre() :?array
{
 return $_SESSION['team'] ?? null;
}

//vérification de la confirmation de l'access a l'utilisateur
 function role(int $role): bool
 {
  
    if (getMembre() === null){
      
      return false;
    } 
  
      return getMembre()['statut'] == $role;
         
 }

 