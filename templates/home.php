<?php $this->title = 'Accueil' ?>

<div id="session" hidden>
    <?= $this->session->show('login_message') ?>
    <?= $this->session->show('register') ?>
    <?= $this->session->show('validation') ?>
    <?= $this->session->show('logout') ?>
    <?= $this->session->show('admin_access') ?>
    <?= $this->session->show('password_recovery') ?>
    <?= $this->session->show('pw_change') ?>
    <?= $this->session->show('profile_change') ?>
</div>

<div id="header-image">
    <div id="cover"></div>
    <img src="images/Alaska-background.png" alt="Montagnes d'Alaska">
    <h1 class="header-title">Billet simple pour l'Alaska</h1>
    <div class="link center-align">
        <a class="btn waves-effect waves-light blue-grey lighten-1" href="index.php?route=article&articleId=<?= $firstId ?>">Retrouvez mon premier article</a>
    </div>
</div>

<div class="content">
    <div class="row">
        <?php foreach ($articles as $article) : ?>
            <a href="./index.php?route=article&articleId=<?= $article->getId(); ?>">
                <div class="card hoverable blue-grey white-text z-depth-2">
                    <div class="card-content">
                        <strong class="card-title"><?= htmlspecialchars($article->getTitle()); ?></strong>
                        <p><?= $article->getCaption(); ?></p>
                    </div>
                    <div class="card-action">
                        Par : <?= htmlspecialchars($article->getAuthor()); ?>, le <?= htmlspecialchars($article->getCreatedAt()); ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
        <div class="row">
            <ul class="pagination center-align">
                <li class="<?= $page <= 1 ? 'disabled' : 'waves-effect' ?>">
                    <a <?php if ($page > 1) { ?>href="/index.php?page=<?= $page - 1 ?>" <?php } ?>><i class="material-icons">chevron_left</i></a>
                </li>
                <li  class="<?= $page >= $count ? 'disabled' : 'waves-effect' ?>">
                    <a <?php if ($page < $count) { ?>href="/index.php?page=<?= $page + 1 ?>" <?php } ?>><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>
        </div>
    </div>
</div>