<?php $this->title = 'S\'inscrire' ?>

<p>
    <?= $this->session->show('pw_no_match'); ?>
</p>

<form method="POST" action="./index.php?route=register">
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="username">Pseudo</label>
            <input type="text" id="username" name="username" value="<?= isset($post) ? $post->get('username') : '' ?>">
            <?= isset($errors['username']) ? $errors['username'] : '' ?>
        </div>
    </div>
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= isset($post) ? $post->get('email') : '' ?>">
            <?= isset($errors['email']) ? $errors['email'] : '' ?>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
            <?= isset($errors['password']) ? $errors['password'] : '' ?>
        </div>
    </div>
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="cPassword">Confirmer le mot de passe</label>
            <input type="password" id="cPassword" name="cPassword">
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <input class="btn green" type="submit" value="S'inscrire" id="submit" name="submit">
        </div>
    </div>
</form>