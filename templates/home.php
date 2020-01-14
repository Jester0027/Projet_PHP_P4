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

<div class="row">
    <?php foreach ($articles as $article) : ?>
        <a href="./index.php?route=article&articleId=<?= $article->getId(); ?>">
            <div class="card indigo lighten-1 white-text z-depth-3">
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