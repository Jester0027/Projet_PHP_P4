<?php $this->title = 'Espace administration' ?>

<h1>Administration</h1>

<div class="row">
    <h3>Articles</h3>
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