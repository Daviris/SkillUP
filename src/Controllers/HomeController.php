<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

class HomeController
{
    public function index(Request $request): void
    {
        View::render('home', ['title' => 'SkillUP']);
    }
}