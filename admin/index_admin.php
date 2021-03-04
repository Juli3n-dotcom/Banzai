<?php
require_once __DIR__ . '/assets/config/bootstrap_admin.php';


$page_title ='';
include __DIR__. '/assets/includes/header_admin.php';
?>
<?php include __DIR__.'/../global/includes/flash.php';?>

<div class="index_header">
  <p id="date"></p>
  <h1>Bonjour <?= $Membre['prenom'] ?></h1>
</div>





<?php
include __DIR__.'/assets/includes/footer_admin.php';
?>