<?php $this->title = 'Espace administration' ?>

<h1>Administration</h1>

<div class="row">
    <h3>Articles</h3>
    <div class="row">
        <a href="index.php?route=addArticle" class="btn waves-effect waves-light green">Ajouter un article</a>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Créé le</th>
            <th>Par</th>
            <th>Actions</th>
        </tr>
        <?php
        if($articles) {
            foreach ($articles as $article) { ?>
            <tr>
                <td><?= $article->getId() ?></td>
                <td><?= $article->getTitle() ?></td>
                <td><?= $article->getCreatedAt() ?></td>
                <td><?= $article->getAuthor() ?></td>
                <td>
                    <a href="index.php">Modifier</a>
                    <a href="index.php" class="red-text">Supprimer</a>
                </td>
            </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="5">
                    <p class="center-align">Aucun article</p>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="row">
    <h3>Utilisateurs</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Pseudo</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        if($users) {
            foreach ($users as $user) { ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getRole() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getStatus() ?></td>
                <td>
                    <a href="index.php" class="red-text">Supprimer</a>
                </td>
            </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="5">
                    <p class="center-align">Aucun article</p>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>