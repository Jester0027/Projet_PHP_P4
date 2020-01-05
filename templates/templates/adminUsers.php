<h3>Utilisateurs</h3>
<table class="responsive-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pseudo</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th class="right-align">Actions</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>