<?php $this->title = 'Espace administration' ?>

<div class="row">
    <div class="col s12 centered">
        <ul class="tabs blue-text">
            <li id="articlesSelector" class="tab col s4"><a class="active" href="#articles">Articles</a></li>
            <li id="usersSelector" class="tab col s4"><a href="#users">Utilisateurs</a></li>
            <li id="reportsSelector" class="tab col s4"><a href="#reports">Commentaires signalés</a></li>
        </ul>
    </div>
</div>

<p><?= $this->session->show('login_message') ?></p>

<h1>Administration</h1>


<div class="row" id="articles"></div>

<div class="row" id="users"></div>

<div class="row" id="reports"></div>