<?php $this->title = 'Modifier l\'article: ' . htmlspecialchars($article->getTitle()); ?>

<form method="POST" action="./index.php?route=editArticle&articleId=<?= $articleId ?>">
    <div class="row">
        <div class="input-field col s12">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($article->getTitle()) ?>">
        </div>
        <div class="col s12">
            <label for="content">Contenu</label>
            <textarea class="tinymce" name="content" id="content"><?= htmlspecialchars($article->getContent()) ?></textarea>
        </div>
        <div class="input-field col s12">
            <label for="caption">Description</label>
            <textarea class="materialize-textarea" name="caption" id="caption"><?= htmlspecialchars($article->getCaption()) ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn waves-effect waves-light green" name="submit" id="submit"><i class="material-icons left">add</i>Modifier</button>
        </div>
    </div>
</form>