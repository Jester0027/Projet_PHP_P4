<?php $this->title = 'Accueil' ?>

<div class="row">
    <?php foreach($articles as $article) : ?>
        <a href="./?route=article&articleId=<?= $article->getId(); ?>">
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