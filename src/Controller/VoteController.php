<?php


namespace App\Controller;

use App\Model\LegendManager;
use App\Model\MemeManager;



class VoteController extends AbstractController
{

    public function showVoteId(int $id): string
    {
        $memeManager = new MemeManager();
        $legendManager = new LegendManager();
        $legends = $legendManager->selectOneById($id);
        $memes = $memeManager->selectOneById($id);

        return $this->twig->render('Meme/vote.html.twig', [
            'memes' => $memes,
            'legends' => $legends




        ]);
    }


}
