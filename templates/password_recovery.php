<?php $this->title = 'Changer mon mot de passe' ?>

<div class="row">
    <div class="col m6 offset-m3 s12">
        <h5>Changer mon mot de passe</h5>
    </div>
</div>

<form method="POST" action="index.php?route=changePassword">

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
        </div>
    </div>
    
    <input type="hidden" name="token" value="<?= $token ?>">
    <input type="hidden" name="email" value="<?= $email ?>">

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <button class="btn waves-effect waves-light green">Envoyer</button>
        </div>
    </div>
</form>