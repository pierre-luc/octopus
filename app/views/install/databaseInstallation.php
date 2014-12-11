<?php
namespace octopus\app\views\install;
use octopus\core\Router;
?>

<div class="login" style="">
    <div class="login-screen">
        <div class="login-icon">
            <img src="<?= Router::generate( 'img/icons/svg/clipboard.svg' );?>" alt="Welcome to Mail App">
            <h4><?= $appname?><small>Installation</small></h4>
        </div>

        <p class="lead">Installation en cours</p>
        <p>
            Le processus d'installation crée la base de données. Cela peut prendre un moment.
        </p>
        <img src="<?= Router::generate( 'img/preloader/barloader.gif' )?>" alt=""/>
    </div>
</div>




