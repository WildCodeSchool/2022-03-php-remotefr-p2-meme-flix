<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\LegendManager;
use App\Model\MemeManager;

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

    /**
     * Show informations for a specific item
     */
    public function show(int $id): string
    {
        $memeManager = new MemeManager();
        $meme = $memeManager->selectOneById($id);

        return $this->twig->render('Meme/vote.html.twig', ['meme' => $meme]);
    }

    /**
     * Add a new item
     */
    public function add(): ?string
    {

        $dataErrors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newMeme = array_map('trim', $_POST);


            $uploadDir = __DIR__ . '/../../public/uploads/images/';

            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $fileName = uniqid() . '.' . $extension;

            $uploadFile = $uploadDir . basename($fileName);

            $authorizedExtensions = ['jpg', 'gif', 'webp', 'png'];

            $maxFileSize = 1000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $dataErrors[] = 'Format invalide (gif, jpg, png, webp)';
            }

            if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $dataErrors[] = 'Ton image doit faire moins de 1Mo';
            }
            if (empty($dataErrors)) {
                $newMeme['image'] = $fileName;
                $newMeme['user_id'] = 'NULL';
                $memeManager = new MemeManager();
                $insertId = $memeManager->insert($newMeme);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
                if ($insertId) {
                    header("Location: /meme/show?id=" . $insertId);
                    return null;
                }
            }

        }
        $categoryManager = new CategoryManager();
        $legendManager = new LegendManager();
        return $this->twig->render('Meme/create.html.twig', [
            'categories' => $categoryManager->selectAll(),
            'legends' => $legendManager->selectAll()

        ]);
    }
}
