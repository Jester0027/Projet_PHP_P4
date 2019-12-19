<?php $this->title = 'Récupération de mot de passe' ?>

<div class="row">
    <div class="col m6 offset-m3 s12">
        <h5>Mot de passe oublié</h5>
    </div>
</div>
<form method="POST" action="index.php?route=lostPassword">
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="email">Entrez votre adresse email</label>
            <input type="email" name="email" id="email">
        </div>
    </div>
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <button class="btn waves-effect waves-light green">Envoyer</button>
        </div>
    </div>
</form>