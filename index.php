<?php
$page_title ='Accueil';
include __DIR__. '/assets/includes/header.php'
?>

<section class="landing">

   <div class="content">
       <div class="contentBx w50">
           <h1><?= $web_name ;?></h1>
           <h3>Agence Web Indépendante</h3>
           <div class="landing__btn">
               <a href="#">Un Projet ?</a>
           </div>
       </div>
       
   </div>

</section>


<section class="work" id="work">
    <div class="title__heading">
        <h3>Notre</h3>
        <h4>Savoir faire</h4>
        <p>
            Nous sommes là pour vous accompagner
            dans vos differents projets web !
        </p>
    </div>

    
    <div class="work__part" id="website">
        <h3>Création</h3>
        <h4>Site Vitrine</h4>
    </div>
    

</section>


<?php
include __DIR__. '/assets/includes/footer.php'
?>