<?php $this->title = 'Profil : ' . $this->session->get('username'); ?>

<h1>Profil de <?= $this->session->get('username') ?></h1>

<div id="session" hidden>
    <?= $this->session->show('profile_change'); ?>
</div>

<ul class="collapsible expandable">
    <li class="<?= isset($emailErrors) ? 'active' : '' ?>">
        <div class="collapsible-header"><i class="material-icons left">email</i>E-mail</div>
        <div class="collapsible-body">
            <h5>Changer l'adresse E-mail</h5>
            <form method="POST" action="index.php?route=changeEmail">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="changeMailEmail">Adresse E-mail actuelle</label>
                        <input type="email" id="changeMailEmail" name="email" value="<?= $user->getEmail() ?>" disabled>
                    </div>
                    <div class="input-field col s12">
                        <label for="changeMailPassword">Mot de passe</label>
                        <input type="password" id="changeMailPassword" name="password">
                        <p class="red-text"><?= $emailErrors['password'] ?? '' ?></p>
                    </div>
                    <div class="input-field col s12">
                        <label for="newEmail">Nouvelle adresse E-mail</label>
                        <input type="email" id="newEmail" name="newEmail">
                        <p class="red-text"><?= $emailErrors['newEmail'] ?? '' ?></p>
                    </div>
                    <div class="input-field col s12">
                        <button type="submit" class="btn green">Changer l'adresse E-mail</button>
                    </div>
                </div>
            </form>
        </div>
    </li>
    <li class="<?= isset($pwErrors) ? 'active' : '' ?>">
        <div class="collapsible-header"><i class="material-icons left">security</i>Mot de passe</div>
        <div class="collapsible-body">
            <h5>Changer le mot de passe</h5>
            <form method="POST" action="index.php?route=changePassword">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="changePasswordEmail">Adresse E-mail</label>
                        <input type="email" id="changePasswordEmail" name="email" value="<?= $user->getEmail() ?>" disabled>
                    </div>
                    <div class="input-field col s12">
                        <label for="changePasswordPassword">Mot de passe</label>
                        <input type="password" id="changePasswordPassword" name="password">
                        <p class="red-text"><?= $pwErrors['password'] ?? '' ?></p>
                    </div>
                    <div class="input-field col s12">
                        <label for="newPassword">Nouveau mot de passe</label>
                        <input type="password" id="newPassword" name="newPassword">
                        <p class="red-text"><?= $pwErrors['newPassword'] ?? '' ?></p>
                    </div>
                    <div class="input-field col s12">
                        <label for="cNewPassword">Confirmer le mot de passe</label>
                        <input type="password" id="cNewPassword" name="cNewPassword">
                    </div>
                    <div class="input-field col s12">
                        <button type="submit" class="btn green">Changer le mot de passe</button>
                    </div>
                </div>
            </form>
        </div>
    </li>
</ul>

<ul class="collapsible">
    <li class="<?= isset($delAccountError) ? 'active' : '' ?>">
        <div class="collapsible-header red lighten-3"><i class="material-icons left">whatshot</i>Danger Zone</div>
        <div class="collapsible-body red lighten-4">
            <h5>Supprimer le compte</h5>
            <form method="POST" action="index.php?route=deleteAccount">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="deleteAccountEmail">Adresse E-mail</label>
                        <input type="email" id="deleteAccountEmail" name="email" value="<?= $user->getEmail() ?>" disabled>
                    </div>
                    <div class="input-field col s12">
                        <label for="deleteAccountPassword">Mot de passe</label>
                        <input type="password" id="deleteAccountPassword" name="password">
                        <p class="red-text"><?= $delAccountError ?? '' ?></p>
                    </div>
                    <div class="input-field col s12">
                        <button type="submit" class="btn red">Supprimer mon compte</button>
                    </div>
                </div>
            </form>
        </div>
    </li>
</ul>