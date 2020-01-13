<?php $this->title = 'Ajouter un article'; ?>

<form method="POST" action="./index.php?route=addArticle">
    <div class="row">
        <div class="input-field col s12">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= isset($post) ? htmlspecialchars($post->get('title')) : '' ?>">
            <p class="red-text"><?= isset($errors['title']) ? $errors['title'] : '' ?></p>
        </div>
        <div class="col s12">
            <label for="content">Contenu</label>
            <textarea class="tinymce" name="content" id="content"><?= isset($post) ? htmlspecialchars($post->get('content')) : '' ?></textarea>
            <p class="red-text"><?= isset($errors['content']) ? $errors['content'] : '' ?></p>
        </div>
        <div class="input-field col s12">
            <label for="caption">Extrait</label>
            <textarea class="materialize-textarea" name="caption" id="caption"><?= isset($post) ? htmlspecialchars($post->get('caption')) : '' ?></textarea>
            <p class="red-text"><?= isset($errors['caption']) ? $errors['caption'] : '' ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn waves-effect waves-light green" name="submit" id="submit"><i class="material-icons left">add</i>Ajouter</button>
        </div>
    </div>
    
</form>