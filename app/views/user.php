<?php $this->layout('main', ['title' => $title]); ?>

<h1>User</h1>

<form action="/users/<?= $this->e($id) ?>/update" method="post">
    <input type="text" name="firstName" />
    <input type="text" name="lastName" />
    <input type="email" name="email" />
    <input type="password" name="password" />

    <button type="submit">Atualizar</button>
</form>