<?php $this->title = 'Espace administration' ?>


<div id="session" hidden>
    <?= $this->session->show('login_message') ?>
    <?= $this->session->show('add_article') ?>
    <?= $this->session->show('comment_action') ?>
    <?= $this->session->show('user_action') ?>
    <?= $this->session->show('article_access') ?>
</div>

<div class="row">
    <div class="col s12 centered">
        <ul class="tabs blue-text">
            <li id="articlesSelector" class="tab col s4"><a class="active" href="#articles">Articles</a></li>
            <li id="usersSelector" class="tab col s4"><a href="#users">Utilisateurs</a></li>
            <li id="reportsSelector" class="tab col s4"><a href="#reports">Commentaires signalés</a></li>
        </ul>
    </div>
</div>

<div hidden id="selected"></div>
<div hidden id="_adminArticles"><?= $articlesPageCount ?></div>
<div hidden id="_adminUsers"><?= $usersPageCount ?></div>
<div hidden id="_adminReports"><?= $reportsPageCount ?></div>

<div hidden id="page"></div>
<div hidden id="pages"></div>
<div class="row" id="content"></div>

<div class="row">
    <ul class="pagination center-align">
        <li class="waves-effect" id="__prev">
            <a><i class="material-icons">chevron_left</i></a>
        </li>
        <li class="waves-effect" id="__next">
            <a><i class="material-icons">chevron_right</i></a>
        </li>
    </ul>
</div>


