<?php $this->title = 'S\'inscrire' ?>


<form method="POST" action="./index.php?route=register">
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="username">Pseudo</label>
            <input type="text" id="username" name="username" value="<?= isset($post) ? $post->get('username') : '' ?>">
            <p class="red-text"><?= $errors['username'] ?? '' ?></p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= isset($post) ? $post->get('email') : '' ?>">
            <p class="red-text"><?= $errors['email'] ?? '' ?></p>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 offset-m3 s12">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
            <p class="red-text"><?= $errors['password'] ?? '' ?></p>
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
            <button class="btn waves-effect waves-light green" type="submit" id="submit" name="submit">S'inscrire</button>
        </div>
    </div>
</form>