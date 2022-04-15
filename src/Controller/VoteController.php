<?php

namespace App\Controller;

class VoteController extends AbstractController
{
    /**
     * Display home page
     */
    public function vote(): string
    {
        return $this->twig->render('meme/vote.html.twig');
    }
}
