<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('home/index.html.twig');
    }

    public function legals(): string
    {
        return $this->twig->render('/legals.html.twig');
    }
}
