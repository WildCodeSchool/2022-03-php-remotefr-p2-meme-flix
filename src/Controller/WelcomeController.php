<?php

namespace App\Controller;

class WelcomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function welcome(): string
    {
        return $this->twig->render('users/welcome.html.twig');
    }
}
