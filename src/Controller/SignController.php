<?php

namespace App\Controller;

class SignController extends AbstractController
{
    /**
     * Display home page
     */
    public function sign(): string
    {
        return $this->twig->render('users/sign.html.twig');
    }
}
