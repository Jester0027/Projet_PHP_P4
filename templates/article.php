<?php $this->title = htmlspecialchars($article->getTitle()); ?>

<div id="session" hidden>
    <?= $this->session->show('comment') ?>
</div>

<div id="header-image">
    <div id="cover"></div>
    <img src="images/Alaska-header.jpg" alt="Alaska">
    <h1 class="article-title"><?= htmlspecialchars($article->getTitle()); ?></h1>
</div>

<div class="article-content">
    <div class="row">
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
        <h2 id="comments">Commentaires</h2>
        <form method="POST" action="./index.php?route=addComment&articleId=<?= $article->getId(); ?>">
            <div class="input-field col s12">
                <label for="content">Ajouter un commentaire</label>
                <textarea class="materialize-textarea" name="content" id="content"><?= isset($post) ? $post->get('content') : '' ?></textarea>
                <p class="red-text"><?= isset($errors) ? $errors['content'] : '' ?></p>
            </div>
            <div class="input-field col s12 right-align">
                <button type="submit" class="btn waves-effect waves-light green" name="submit">Envoyer</button>
            </div>
        </form>
    
        <?php foreach($comments as $comment) : ?>
            <div class="row">
                <h6><?= htmlspecialchars($comment->getAuthor()); ?> le <?= htmlspecialchars($comment->getCreatedAt()); ?></h6>
                <p><?= htmlspecialchars($comment->getContent()); ?></p>
                <a class="red-text" href="index.php?route=reportComment&commentId=<?= $comment->getId() ?>&articleId=<?= $article->getId() ?>">Signaler ce commentaire</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>