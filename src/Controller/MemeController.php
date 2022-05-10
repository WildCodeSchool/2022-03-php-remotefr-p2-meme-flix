<?php

namespace App\Controller;

use App\Model\MemeManager;
use App\Model\UserManager;
use App\Model\VoteManager;
use App\Model\LegendManager;
use App\Model\CategoryManager;

class MemeController extends AbstractController
{
    public function index(): string
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectDistinctAll();
        $memeManager = new MemeManager();
        $memes = $memeManager->selectAll();

        return $this->twig->render('Home/index.html.twig', [
            'categories' => $categories,
            'memes' => $memes
        ]);
    }

    public function legals(): string
    {
        return $this->twig->render('/legals.html.twig');
    }


    public function showVoteId(int $id): string
    {
        $memeManager = new MemeManager();
        $meme = $memeManager->selectOneById($id);
        $legendManager = new LegendManager();
        $legends = $legendManager->selectAllAndVotesByMemeId($id);

        return $this->twig->render('Meme/vote.html.twig', [
            'meme' => $meme,
            'legends' => $legends
        ]);
    }


    public function add(): ?string
    {
        if (!$this->user) {
            header('Location: /register');
            return null;
        }
        $dataErrors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newMeme = array_map('trim', $_POST);
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . basename($fileName);
            $authorizedExtensions = ['jpg', 'gif', 'webp', 'png', 'jpeg'];
            $maxFileSize = 1000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $dataErrors[] = 'Format invalide (gif, jpg, png, webp)';
            }

            if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $dataErrors[] = 'Ton image doit faire moins de 1Mo';
            }

            if (empty($_POST['category'])) {
                $dataErrors[] = 'Tu doit choisir une catégorie';
            }

            if (empty($_POST['legend'])) {
                $dataErrors[] = 'Tu doit mettre un message';
            }

            if (empty($dataErrors)) {
                $newMeme['image'] = $fileName;
                $newMeme['user_id'] =  $_SESSION['user_id'];
                $memeManager = new MemeManager();
                $insertId = $memeManager->insert($newMeme);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
                if ($insertId) {
                    header("Location: /");
                    return null;
                }
            }
        }
        $categoryManager = new CategoryManager();
        $legendManager = new LegendManager();

        return $this->twig->render('Meme/create.html.twig', [
            'categories' => $categoryManager->selectAll(),
            'legends' => $legendManager->selectAll(),
            'dataErrors' => $dataErrors
        ]);
    }

    public function addVote(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newVote = [];
            $newVote['id'] = $_POST['legend'];
            $newVote['user_id'] = $this->user['id'];
            $voteManager = new VoteManager();
            $voteManager->insert($newVote);
            header('Location:/vote?id=' . $id);
            return null;
        }
    }
}
