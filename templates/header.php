<?php
$route = $get->get('route');
?>
<header>
    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="index.php" class="brand-logo center" id="brand-logo"><div id="logo-block"><img id="logo" src="images/LogoMakr_1jlJPy.png" alt="logo Jean Forteroche"></div></a>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="left hide-on-med-and-down">
                <?php if ($session->get('username')) {
                    ?>
                    <li class="<?= $route === 'logout' ? 'active' : '' ?>"><a href="./index.php?route=logout">Se déconnecter</a></li>
                    <li class="<?= $route === 'profile' ? 'active' : '' ?>"><a href="./index.php?route=profile">Profil</a></li>
                <?php
                } else {
                    ?>
                    <li class="<?= $route === 'login' ? 'active' : '' ?>"><a href="./index.php?route=login">Se connecter</a></li>
                    <li class="<?= $route === 'register'  ? 'active' : '' ?>"><a href="./index.php?route=register">S'inscrire</a></li>
                <?php
                } ?>
            </ul>
            <ul class="right hide-on-med-and-down">
                <li class="<?= !$route ? 'active' : '' ?>"><a href="./index.php">Accueil</a></li>
                <?php if ($session->get('role') === 'admin') {
                    ?>
                    <li class="<?= $route === 'admin' ? 'active' : '' ?>"><a href="./index.php?route=admin">Administration</a></li>
                <?php
                } ?>
            </ul>
        </div>
    </nav>
</header>

<ul id="slide-out" class="sidenav">
    <?php if ($session->get('username')) {
        ?>
        <li class="<?= $route === 'logout' ? 'active' : '' ?>"><a class="red-text" href="./index.php?route=logout">Se déconnecter<i class="material-icons left red-text">exit_to_app</i></a></li>
        <li class="<?= $route === 'profile' ? 'active' : '' ?>"><a href="./index.php?route=profile">Profil<i class="material-icons left">account_box</i></a></li>
    <?php
    } else {
        ?>
        <li class="<?= $route === 'login' ? 'active' : '' ?>"><a href="./index.php?route=login">Se connecter<i class="material-icons left">person</i></a></li>
        <li class="<?= $route === 'register'  ? 'active' : '' ?>"><a href="./index.php?route=register">S'inscrire<i class="material-icons left">person_add</i></a></li>
    <?php
    } ?>
    <li class="<?= !$route ? 'active' : '' ?>"><a href="./index.php">Accueil<i class="material-icons left">home</i></a></li>
    <?php if ($session->get('role') === 'admin') {
        ?>
        <li class="<?= $route === 'admin' ? 'active' : '' ?>"><a href="./index.php?route=admin">Administration<i class="material-icons left">supervisor_account</i></a></a></li>
    <?php
    } ?>
</ul>