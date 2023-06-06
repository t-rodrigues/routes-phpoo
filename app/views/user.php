<?php $this->layout('main', ['title' => $title]); ?>

<div class="d-flex flex-column align-items-center">
    <h1>User</h1>
    <?= flash('created') ?>

    <form class="w-75" action="/users/<?= $this->e($id) ?>/update" method="post">
        <?= getToken(); ?>

        <?= flash('firstName') ?>
        <div class="form-floating mb-3">
            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Nome" />
            <label for="firstName">Nome</label>
        </div>
        <?= flash('lastName') ?>
        <div class="form-floating mb-3">
            <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Sobrenome" />
            <label for="lastName">Sobrenome</label>
        </div>
        <?= flash('email') ?>
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="johndoe@mail.com">
            <label for="floatingInput">E-mail</label>
        </div>
        <?= flash('password') ?>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
</div>