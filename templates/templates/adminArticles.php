<p><?= $this->session->show('login_message') ?></p>
<h3>Articles</h3>
<div class="row">
    <a href="index.php?route=addArticle" class="btn waves-effect waves-light green"><i class="material-icons left">create</i>Ajouter un article</a>
</div>
<p class="indigo-text">
    <?= $this->session->show('add_article') ?>
    <?= $this->session->show('comment_action') ?>
    <?= $this->session->show('user_action') ?>
    <span class="red-text"><?= $this->session->show('article_access') ?></span>
</p>
<table class="responsive-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Créé le</th>
            <th>Par</th>
            <th class="right-align">Actions</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>