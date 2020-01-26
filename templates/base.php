<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= $description ?>">
    <title>Jean Forteroche - <?= $title ?></title>

    <script src="https://cdn.tiny.cloud/1/7oil4153ta5v1d7qubez5x7rha8a4qm6gjy18orgior3k9m0/tinymce/5/tinymce.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?= $header ?>
    <main class="container">
        <?= $content ?>
    </main>
    <?= $footer ?>

    <script src="js/main.js"></script>
    <?php foreach($cdn as $link) { ?>
        <script type="text/javascript" src="<?= $link ?>"></script>
    <?php } ?>
    <?php foreach($scriptFiles as $jsFile) { ?>
        <script type="text/javascript" src="js/<?= $jsFile ?>.js"></script>
    <?php } ?>
</body>
</html>