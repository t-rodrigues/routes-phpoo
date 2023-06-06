<?php

namespace app\controllers;

use app\database\Filters;
use app\database\models\Pagination;
use app\database\models\User;

class HomeController extends Controller
{
    public function index(): void
    {
        $filters = new Filters;
        // $filters->where('users.id', '>', 2);
        $filters->join('posts', 'users.id', '=', 'posts.user_id', 'inner join');
        $pagination = new Pagination;
        $pagination->setItemsPerPage(10);
        $user = new User;
        $user->setFields('users.id,firstName,lastName,title');
        $user->setFilters($filters);
        $user->setPagination($pagination);
        $usersFound = $user->fetchAll();

        $this->view('home', ['title' => 'Home', 'users' => $usersFound, 'pagination' => $pagination]);
    }
}
