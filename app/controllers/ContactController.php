<?php

namespace app\controllers;

use app\support\Email;
use app\support\Flash;
use app\support\Validate;

class ContactController extends Controller
{
    public function index()
    {
        $this->view('contact', ['title' => 'Entrar em contato']);
    }

    public function store()
    {
        $validate = new Validate;
        $validated = $validate->validate([
            'email' => 'email|required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        if (!$validated) {
            return redirect("/contact");
        }

        $email = new Email;
        $sent = $email->from('hey@thiagorodrigues.dev', 'Thiago Rodrigues')
            ->to($validated['email'])
            ->subject($validated['subject'])
            ->template('contact', ['name' => 'John Doe'])
            ->message($validated['message'])
            ->send();

        if ($sent) {
            Flash::set('sent_success', 'Boa manito');
            return redirect('/contact');
        }

        Flash::set('sent_error', 'Deu ruim ao enviar o e-mail meu camarada');
        return redirect('/contact');
    }
}
