<?php

namespace App\Controller;

class UserController extends AbstractController
{
    /**
     * Display home page
     */
    public function register(): string
    {
        return $this->twig->render('Users/register.html.twig');
    }
}
