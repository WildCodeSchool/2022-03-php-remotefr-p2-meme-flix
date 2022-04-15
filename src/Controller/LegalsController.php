<?php

namespace App\Controller;

class LegalsController extends AbstractController
{
    /**
     * Display home page
     */
    public function legals(): string
    {
        return $this->twig->render('legals.html.twig');
    }
}
