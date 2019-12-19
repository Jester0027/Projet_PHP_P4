<?php $this->title = htmlspecialchars($article->getTitle()); ?>

<div class="row">
    <div class="col m6 offset-m3 s12">
        <h2 class="center-align"><?= htmlspecialchars($article->getTitle()); ?></h2>
        
    </div>
    <div class="col s12">
        <hr>
    </div>
    <div class="row">
        <div class="col s12">
            <?= $article->getContent(); ?>
        </div>
    </div>
    <div class="row">
        <p>Par : <?= htmlspecialchars($article->getAuthor()); ?></p>
        <p>Le : <?= htmlspecialchars($article->getCreatedAt()); ?></p>
    </div>
</div>

<div class="row">
    <h2>Commentaires</h2>
    <form method="POST" action="./index.php?route=addComment&articleId=<?= $article->getId(); ?>">
        <div class="input-field col s12">
            <label for="content">Ajouter un commentaire</label>
            <textarea class="materialize-textarea" name="content" id="content"></textarea>
        </div>
        <div class="input-field col s12 right-align">
            <button type="submit" class="btn waves-effect waves-light green" name="submit">Envoyer</button>
        </div>
    </form>

    <?php foreach($comments as $comment) : ?>
        <div class="row">
            <h6><?= htmlspecialchars($comment->getAuthor()); ?> le <?= htmlspecialchars($comment->getCreatedAt()); ?></h6>
            <p><?= htmlspecialchars($comment->getContent()); ?></p>
            <a class="red-text" href="index.php?route=reportComment&commentId=<?= $comment->getId() ?>">Signaler ce commentaire</a>
        </div>
    <?php endforeach; ?>
</div>