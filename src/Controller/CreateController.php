<?php

namespace App\Controller;

class CreateController extends AbstractController
{
    /**
     * Display home page
     */
    public function create(): string
    {
        return $this->twig->render('meme/create.html.twig');
    }
}
