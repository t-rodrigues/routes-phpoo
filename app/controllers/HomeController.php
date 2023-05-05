<?php

namespace app\controllers;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home', ['title' => 'Home']);
    }
}
