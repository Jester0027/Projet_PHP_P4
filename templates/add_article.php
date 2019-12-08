<?php $this->title = 'Ajouter un article'; ?>

<form method="POST" action="./?route=addArticle">
    <div class="row">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title">
    </div>
    <div class="row">
        <label for="content">Contenu</label>
        <textarea class="tinymce" name="content" id="content"></textarea>
    </div>
    <input type="submit" class="btn green" name="submit" id="submit" value="Ajouter">
</form>