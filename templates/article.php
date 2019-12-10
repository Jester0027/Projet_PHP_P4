<?php $this->title = 'Article' ?>

<div class="row">
    <h2><?= htmlspecialchars($article->getTitle()); ?></h2>
    <div>
        <?= $article->getContent(); ?>
    </div>
    <div class="row">
        <p>Par : <?= htmlspecialchars($article->getAuthor()); ?></p>
        <p>Le : <?= htmlspecialchars($article->getCreatedAt()); ?></p>
    </div>
</div>

<div class="row">
    <form action="./?route=addComment&articleId=<?= $article->getId(); ?>">
        <label for="comment">Ajouter un commentaire</label>
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <input type="submit" class="btn waves-effect waves-light green" name="submit" value="Envoyer">
    </form>
    <h2>Commentaires</h2>

    <?php foreach($comments as $comment) : ?>
        <h6><?= htmlspecialchars($comment->getAuthor()); ?></h6>
        <p>le <?= htmlspecialchars($comment->getCreatedAt()); ?></p>
        <p><?= htmlspecialchars($comment->getContent()); ?></p>
    <?php endforeach; ?>
</div>