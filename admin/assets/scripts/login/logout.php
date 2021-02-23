<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
unset($_SESSION['team']);
ajouterFlash('success','Vous avez été déconnecté');
header('location: ../../../login_admin.php');