<h3>Commentaires signalés</h3>
<table class="responsive-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Commentaire</th>
            <th>Créé le</th>
            <th>Par</th>
            <th class="right-align">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if($reportedComments) { ?>
            <?php foreach ($reportedComments as $reportedComment) { ?>
            <tr>
                <td><?= $reportedComment->getId() ?></td>
                <td><?= $reportedComment->getContent() ?></td>
                <td><?= $reportedComment->getCreatedAt() ?></td>
                <td><?= $reportedComment->getAuthor() ?></td>
                <td class="right-align">
                    <a id="delete_user" href="index.php?route=deleteComment&commentId=<?= $reportedComment->getId() ?>" class="btn waves-effect waves-light red"><i class="material-icons left">delete</i>Supprimer</a>
                    <a href="index.php?route=pardonComment&commentId=<?= $reportedComment->getId() ?>" class="btn waves-effect waves-light green">Désignaler</a>
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
    </tbody>
</table>