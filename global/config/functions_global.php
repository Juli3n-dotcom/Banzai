<?php

function ajouterFlash(string $type, string $messages) : void
  {
      $_SESSION['flash'][] = [
       'type' => $type,
       'message' => $messages,
];
  }

function recupererFlash ():array{

$messages = $_SESSION['flash'] ??[];

unset($_SESSION['flash']);

    return $messages;
  }


