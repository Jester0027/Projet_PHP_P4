<?php $this->title = 'Modifier l\'article: ' . htmlspecialchars($article->getTitle()); ?>

<form method="POST" action="./index.php?route=editArticle&articleId=<?= $articleId ?>">
    <div class="row">
        <div class="input-field col s12">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= isset($errors) ? htmlspecialchars($post->get('title')) : htmlspecialchars($article->getTitle()) ?>">
            <?= isset($errors['title']) ? $errors['title'] : '' ?>
        </div>
        <div class="col s12">
            <label for="content">Contenu</label>
            <textarea class="tinymce" name="content" id="content"><?= isset($errors) ? htmlspecialchars($post->get('content')) : htmlspecialchars($article->getContent()) ?></textarea>
            <?= isset($errors['content']) ? $errors['content'] : '' ?>
        </div>
        <div class="input-field col s12">
            <label for="caption">Extrait</label>
            <textarea class="materialize-textarea" name="caption" id="caption"><?= isset($errors) ? htmlspecialchars($post->get('caption')) : htmlspecialchars($article->getCaption()) ?></textarea>
            <?= isset($errors['caption']) ? $errors['caption'] : '' ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn waves-effect waves-light green" name="submit" id="submit"><i class="material-icons left">add</i>Modifier</button>
        </div>
    </div>
</form>