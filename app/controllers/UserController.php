<?php

namespace app\controllers;

class UserController
{
    public function index()
    {
        dd('user controller index');
    }

    public function show($params)
    {
        dd('user controller show', $params);
    }

    public function edit($params)
    {
        dd('user controller edit', $params);
    }
}
