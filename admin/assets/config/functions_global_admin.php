<?php

// récupération des membres de la team
function getTeam_members(PDO $pdo):array
{
  $req=$pdo->query(
    'SELECT *
    FROM team
  ');
 $tmember = $req->fetchAll(PDO::FETCH_ASSOC);
return $tmember;
}
