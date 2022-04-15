<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    /**
     * Display home page
     */
    public function admin(): string
    {
        return $this->twig->render('private/admin.html.twig');
    }
}
