<?php $this->title = 'Ajouter un article'; ?>

<form method="POST" action="./index.php?route=addArticle">
    <div class="row">
        <div class="input-field col s12">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title">
        </div>
        <div class="col s12">
            <label for="content">Contenu</label>
            <textarea class="tinymce" name="content" id="content"></textarea>
        </div>
        <div class="input-field col s12">
            <label for="caption">Description</label>
            <textarea class="materialize-textarea" name="caption" id="caption"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn waves-effect waves-light green" name="submit" id="submit"><i class="material-icons left">add</i>Ajouter</button>
        </div>
    </div>
    
</form>