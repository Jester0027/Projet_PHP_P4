<?php
$route = $get->get('route');
?>

<header>
    <nav class="indigo">
        <div class="nav-wrapper container">
            <a href="./" class="brand-logo center">Jean Forteroche</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li class="<?= !$route ? 'active' : '' ?>"><a href="./">Accueil</a></li>
                <li class="<?= $route === 'addArticle' ? 'active' : '' ?>"><a href="./?route=addArticle">Ajouter un article</a></li>
            </ul>
        </div>
    </nav>
</header>