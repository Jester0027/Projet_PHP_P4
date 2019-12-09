<?php
$route = $get->get('route');
?>
<header>
    <nav class="indigo">
        <div class="nav-wrapper container">
            <a href="./index.php" class="brand-logo center">Jean Forteroche</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <?php if ($session->get('username')) {
                    ?>
                    <li class="<?= $route === 'logout' ? 'active' : '' ?>"><a href="./index.php?route=logout">Se déconnecter</a></li>
                <?php
                } else {
                    ?>
                    <li class="<?= $route === 'login' ? 'active' : '' ?>"><a href="./index.php?route=login">Se connecter</a></li>
                    <li class="<?= $route === 'register'  ? 'active' : '' ?>"><a href="./index.php?route=register">S'inscrire</a></li>
                <?php
                } ?>
            </ul>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
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