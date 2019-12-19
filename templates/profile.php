<?php $this->title = 'Profil : ' . $session->get('username'); ?>

<h1>Profil de <?= $session->get('username') ?></h1>

<p>
    <?= $this->session->show('email_profile_change'); ?>
</p>

<ul class="collapsible expandable">
    <li>
        <div class="collapsible-header"><i class="material-icons">email</i>E-mail</div>
        <div class="collapsible-body">
            <h5>Changer l'adresse E-mail</h5>
            <form method="POST" action="index.php?route=changeEmail">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="input-field col s12">
                        <label for="email">Adresse E-mail actuelle</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="input-field col s12">
                        <label for="newEmail">Nouvelle adresse E-mail</label>
                        <input type="email" id="newEmail" name="newEmail">
                    </div>
                    <div class="input-field col s12">
                        <button type="submit" class="btn green">Changer l'adresse E-mail</button>
                    </div>
                </div>
            </form>
        </div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">security</i>Mot de passe</div>
        <div class="collapsible-body">
            <h5>Changer le mot de passe</h5>
            <form method="POST"action="index.php?route=changePassword">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="input-field col s12">
                        <label for="email">Adresse E-mail</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="input-field col s12">
                        <label for="newPassword">Nouveau mot de passe</label>
                        <input type="email" id="newPassword" name="newPassword">
                    </div>
                    <div class="input-field col s12">
                        <label for="cNewPassword">Confirmer le mot de passe</label>
                        <input type="email" id="cNewPassword" name="cNewPassword">
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
    <li>
        <div class="collapsible-header red lighten-3"><i class="material-icons">whatshot</i>Danger Zone</div>
        <div class="collapsible-body red lighten-4">
            <div class="row valign-wrapper">
                <div class="col m8 s12">
                    <div>
                        <h5>Supprimer le compte</h5>
                    </div>
                </div>
                <div class="col m4 s12">
                    <div>
                        <a href="index.php?route=deleteAccount" class="btn waves-effect waves-light red">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>