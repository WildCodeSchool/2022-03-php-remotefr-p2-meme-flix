<?php

namespace App\Controller;

class ConnectController extends AbstractController
{
    /**
     * Display home page
     */
    public function connect(): string
    {
        return $this->twig->render('users/connect.html.twig');
    }
}
