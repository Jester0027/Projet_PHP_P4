<?php $this->title = 'Se connecter' ?>

<form method="POST" action="./index.php?route=login">
    <div class="row">
        <div class="col m6 offset-m3 s12">
            <p class="red-text"><?= $this->session->show('error_login') ?></p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="username">Pseudo</label>
            <input type="text" id="username" name="username" value="<?= isset($post) ? $post->get('username') : '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <input class="btn green" type="submit" value="Se connecter" id="submit" name="submit">
        </div>
    </div>
</form>