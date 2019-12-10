<?php $this->title = 'Accueil' ?>

<p>
    <?= $this->session->show('login') ?>
    <?= $this->session->show('register') ?>
    <?= $this->session->show('validation') ?>
    <?= $this->session->show('logout') ?>
    <?= $this->session->show('admin_access') ?>
</p>

<div class="row">
    <?php foreach ($articles as $article) : ?>
        <a href="./index.php?route=article&articleId=<?= $article->getId(); ?>">
            <div class="card indigo lighten-1 white-text">
                <div class="card-content">
                    <strong class="card-title"><?= htmlspecialchars($article->getTitle()); ?></strong>
                    <p><?= $article->getContent(); ?></p>
                </div>
                <div class="card-action">
                    Par : <?= htmlspecialchars($article->getAuthor()); ?>, le <?= htmlspecialchars($article->getCreatedAt()); ?>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>