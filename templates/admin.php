<?php $this->title = 'Espace administration' ?>

<h1>Administration</h1>

<div class="row">
    <h3>Articles</h3>
    <div class="row">
        <a href="index.php?route=addArticle" class="btn waves-effect waves-light green"><i class="material-icons left">create</i>Ajouter un article</a>
    </div>
    <p class="indigo-text">
        <?= $this->session->show('add_article') ?>
        <span class="red-text"><?= $this->session->show('article_access') ?></span>
    </p>
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Créé le</th>
            <th>Par</th>
            <th class="right-align">Actions</th>
        </tr>
        <?php
        if($articles) {
            foreach ($articles as $article) { ?>
            <tr>
                <td><?= $article->getId() ?></td>
                <td><a href="index.php?route=article&articleId=<?= $article->getId() ?>"><?= $article->getTitle() ?></a></td>
                <td><?= $article->getCreatedAt() ?></td>
                <td><?= $article->getAuthor() ?></td>
                <td class="right-align">
                    <a href="index.php?route=editArticle&articleId=<?= $article->getId() ?>" class="btn waves-effect waves-light green"><i class="material-icons left">edit</i>Modifier</a>
                    <a href="index.php?route=deleteArticle&articleId=<?= $article->getId() ?>" class="btn waves-effect waves-light red"><i class="material-icons left">delete</i>Supprimer</a>
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
    <p class="indigo-text">
        <?= $this->session->show('user_action') ?>
    </p>
    <table>
        <tr>
            <th>ID</th>
            <th>Pseudo</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th class="right-align">Actions</th>
        </tr>
        <?php
        if($users) {
            foreach ($users as $user) { ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getRole() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getStatus() === '0' ? 'banni' : 'actif' ?></td>
                <td class="right-align">
                    <?php if($user->getRole() === 'user') { ?>
                        <a id="delete_user" href="index.php?route=deleteUser&userId=<?= $user->getId() ?>" class="btn waves-effect waves-light red"><i class="material-icons left">delete</i>Supprimer</a>
                        <a id="ban_user" href="index.php?route=<?= $user->getStatus() === '1' ? 'banUser' : 'unbanUser' ?>&userId=<?= $user->getId() ?>" class="btn waves-effect waves-light red"><i class="material-icons left">gavel</i><?= $user->getStatus() === '0' ? 'Débannir' : 'Bannir' ?></a>
                    <?php } else { ?>
                        <span class="grey-text">aucune action</span>
                    <?php } ?>
                </td>
            </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="5">
                    <p class="center-align">Aucun Utilisateur</p>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="row">
    <h3>Commentaires signalés</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Commentaire</th>
            <th>Créé le</th>
            <th>Par</th>
            <th class="right-align">Actions</th>
        </tr>
            <?php if($reportedComments) { ?>
                <?php foreach ($reportedComments as $reportedComment) { ?>
                <tr>
                    <td><?= $reportedComment->getId() ?></td>
                    <td><?= $reportedComment->getContent() ?></td>
                    <td><?= $reportedComment->getCreatedAt() ?></td>
                    <td><?= $reportedComment->getAuthor() ?></td>
                    <td class="right-align">
                        <a id="delete_user" href="index.php?route=deleteComment&commentId=<?= $reportedComment->getId() ?>" class="btn waves-effect waves-light red"><i class="material-icons left">delete</i>Supprimer</a>
                        <a href="index.php?index.php?route=pardonComment&commentId=<?= $reportedComment->getId() ?>" class="btn waves-effect waves-light green">Désignaler</a>
                    </td>
                </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5">
                        <p class="center-align">Aucun commentaire signalé</p>
                    </td>
                </tr>
            <?php } ?>
    </table>
</div>