<?php
require_once __DIR__ . '/assets/config/bootstrap_admin.php';



$page_title ='Connexion';
include __DIR__. '/assets/includes/header_admin.php';
?>
<?php include __DIR__.'/../global/includes/flash.php';?>

<img src="assets/img/wave.png" alt="wave" class="wave">

<div class="login__container">
    <div class="login__img">
        <img src="assets/img/login.svg" alt="image">
    </div>
    <div class="login__box">
        <form action="assets/scripts/login/login_member.php" method="POST">
            <img class="login__avatar" src="assets/img/profil.svg" alt="image de profil">

            <h2>Bienvenue</h2>

            <div class="login__input--div username">

                <div class="login__input--div-i">
                    <i class="fas fa-user"></i>
                </div>

                <div>
                    <h5>Username</h5>
                    <input 
                    type="text" 
                    class="input__login" 
                    name="username"
                    value=""
                    />
                </div>

            </div> <!-- end login__input--div-->

            <div class="login__input--div password">

                <div class="login__input--div-i">
                    <i class="fas fa-user"></i>
                </div>

                <div>
                    <h5>Password</h5>
                    <input 
                    type="password" 
                    class="input__login"
                    name="password"
                    />
                </div>

            </div> <!-- end login__input--div-->

            <a href="#" class="forgot__password">Mot de passe oublié</a>

            <input 
            type="submit" 
            class="login__btn" 
            name="login"
            value="Connexion"
            />
        </form>
     </div>
</div>

<?php
include __DIR__. '/assets/includes/footer_admin.php';
?>