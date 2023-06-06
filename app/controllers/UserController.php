<?php

namespace app\controllers;

use app\database\models\User;
use app\support\Validate;

class UserController extends Controller
{
    public function index(): void
    {
        dd('user controller index');
    }

    public function show($params): void
    {
        dd('user controller show', $params);
    }

    public function edit(array $params): void
    {
        $this->view('user', [
            'title' => 'Editar usuário',
            'id' => $params[0],
        ]);
        // $query = Request::query('page');
    }

    public function update($params): void
    {
        // Csrf::validateToken();
        $validate = new Validate;
        $validated = $validate->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:' . User::class,
            'password' => 'required|minLen:6'
        ]);
        if (!$validated) {
            redirect("/users/1/edit");
            return;
        }
        dd($validated);
    }
}
