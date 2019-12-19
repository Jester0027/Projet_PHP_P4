<h1>Bonjour <?= $user->getUsername() ?>,</h1>

<p>Vous avez demandé un changement d'adresse Email</p>
<p>Votre ancienne adresse : <?= $post->get('email'); ?></p>
<p>Pour confirmer ce changement, cliquez sur ce lien :</p>
<a href="<?= $link ?>">Confirmer le changement</a>