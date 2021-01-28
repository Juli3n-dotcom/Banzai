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

<section class="about full__page-section" id="about">
    
    <div class="w50 about__left-part title__part">
        <h2>Qui sommes nous?</h2>
    </div>

    <div class="w50 about__right-part">
        <div class="about__right-title">
            <p>Agence Web à taille humaine basé à Courcouronnes</p>
            <span></span>
        </div>

        <div class="about__right-text">
        <p>
            Nous entreprenons un rapport privilégié avec nos clients.
Ecoute, conseil et créativité nous impliquent à vos côtes, tel un partenaire de votre développement digital.
Quel que soit le secteur d’activité, la problématique rencontrée, l’importance du budget, nous vous accompagnons dans vos projets.
        </p>
        </div>

        <div class="about__right-title">
            <p>L'indépendance notre force</p>
            <span></span>
        </div>

        <div class="about__right-text">
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iste molestiae, inventore voluptas fugit nemo laboriosam at! Illo nemo hic cum quas perferendis a, molestiae fuga, debitis autem mollitia rerum eum!
        </p>
        </div>
    </div>

</section>


<section class="work full__page-section" id="work">

    <div class="w50 work__left-part title__part">
        <h2>Nos Services</h2>
    </div>

<div class="w50 work__right-part">
    <div class="web__create">
       <div class="title__heading">
            <h4>Création de</h4>
            <h3>site vitrine</h3>
       </div>
    </div>

     <div class="ecommerce">
        <div class="title__heading">
            <h4>Site</h4>
            <h3>E-Commerce</h3>
       </div>
    </div>

    <div class="reference">
        <div class="title__heading">
            <h3>WebMaster</h3>
       </div>
    </div>

</div>



</section>


<?php
include __DIR__. '/assets/includes/footer.php'
?>