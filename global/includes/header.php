<?php
require_once __DIR__.'/../config/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="banzai.com : est une agence web spécialisée dans le référencement naturel. Elle conseille et met en place tout son savoir faire pour augmenter le positionnement de votre site Internet sur les mots clés de votre domaine d'activité. Obtenez un audit gratuit en contactant BH Internet.">
    <meta name="Keywords" content="Création site web entreprise, création site web paris, création site web essonne, création site web 91, creation site web 77, creation site web professionnel, creation site e-commerce, site vitrine, création site wordpress, agence web">
    <meta name="author" content="Julien Quentier">
   <title><?= $web_name ;?> | <?=$page_title?></title>

   <!-- CSS -->
   <link rel="stylesheet" href="global/css/style.css">
</head>
<body>
    <header>
        <a href="#" class="header__logo"><?= $web_name ;?></a>

         <div class="menu__icon">
            <span class="menu__icon--one"></span>
            <span class="menu__icon--two"></span>
            <span class="menu__icon--three"></span>
        </div>

        <ul class="menu">
                <?php 
                    $class='nav-link';
                    require 'menu.php';
                ?>
            </ul>

    </header>
</body>
</html>