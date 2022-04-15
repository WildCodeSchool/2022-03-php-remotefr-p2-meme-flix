<?php

namespace App\Controller;

class EditController extends AbstractController
{
    /**
     * Display home page
     */
    public function edit(): string
    {
        return $this->twig->render('meme/edit.html.twig');
    }
}
