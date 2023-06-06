<?php $this->layout('main', ['title' => $title]); ?>

<h1>Home (<?= $pagination->getTotal(); ?>)</h1>

<h3><?= $pagination->getItemsPerPage(); ?></h3>

<ul>
    <?php foreach ($users as $user) : ?>
        <li><?= $user->firstName; ?></li>
    <?php endforeach; ?>
</ul>

<?= $pagination->links(); ?>