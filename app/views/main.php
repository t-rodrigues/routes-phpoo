<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->section('css') ?>

    <title><?= $this->e($title) ?? 'PHP' ?></title>
</head>

<body>
    <?php $this->insert('partials/header') ?>

    <main class="container">
        <?= $this->section('content') ?>
    </main>
</body>

</html>