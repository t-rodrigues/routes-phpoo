<?php $this->layout('main', ['title' => $title]); ?>

<h1>Contato</h1>
<?= flash('sent_success') ?>
<?= flash('sent_error') ?>

<form action="/contact" method="post">
    <?= getToken(); ?>

    <?= flash('email') ?>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail:</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="josedoegito@mail.com">
    </div>

    <?= flash('subject') ?>
    <div class="mb-3">
        <label for="subject" class="form-label">Assunto:</label>
        <input name="subject" type="subject" class="form-control" id="subject" placeholder="Olá mundo!">
    </div>

    <?= flash('message') ?>
    <div class="mb-3">
        <label for="message" class="form-label">Mensagem:</label>
        <textarea name="message" class="form-control" id="message" rows="3">Você falou pipoca?</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Enviar</button>
</form>