<?php

namespace app\controllers;

use app\core\Request;

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
        $query = Request::query('page');
        dd($query);
    }

    public function update($params): void
    {
        // $request = Request::only('firstName');
        // $request = Request::only(['password', 'firstName', 'email']);
        // $request = Request::excepts('password');
        $request = Request::excepts(['password', 'lastName']);
        dd($request);
    }
}
