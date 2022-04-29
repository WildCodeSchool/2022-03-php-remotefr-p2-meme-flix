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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $newMeme = array_map('trim', $_POST);

            $errors = [];

            $uploadDir = __DIR__ . '/../../public/uploads/images/';

            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $fileName = uniqid() . '.' . $extension;

            $uploadFile = $uploadDir . basename($fileName);

            move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

            $authorizedExtensions = ['jpg', 'gif', 'webp', 'png'];

            $maxFileSize = 1000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $errors[] = 'Format invalide (gif, jpg, png, webp)';
            }

            if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $errors[] = 'Ton image doit faire moins de 1Mo';
            }
            if (empty($errors)) {
                $newMeme['image'] = $fileName;
                $newMeme['user_id'] = 'NULL';
                $memeManager = new MemeManager();
                $insertId = $memeManager->insert($newMeme);
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


    // public function edit(int $id)
    // {
    //     $memeManager = new MemeManager();
    //     $meme = $memeManager->selectOneById($id);
    //     if (!$this->user || $this->user['id'] !== $meme['user_id']) {
    //         header('Location: /login');
    //         return null;
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // clean $_POST data
    //         $meme = array_map('trim', $_POST);

    //         // if (!empty($_FILES['picture']['name'])) {
    //         //     $fileName =  basename($_FILES['picture']['name']);
    //         //     $uploadFile = __DIR__ . '/../../public/uploads/' . $fileName;
    //         //     move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile);
    //         //     $instrument['picture'] = $fileName;
    //         // }
    //         $memeManager->update($meme);
    //         header('Location: /');
    //         return null;
    //     }

    //     $meme = $memeManager->selectOneById($id);
    //     $categoryManager = new CategoryManager();
    //     $categories = $categoryManager->selectAll();
    //     $legendManager = new LegendManager();
    //     $legends = $legendManager->selectAll();
    //     return $this->twig->render('Meme/create.html.twig', [
    //         'meme' => $meme,
    //         'categories' => $categories,
    //         'legends' => $legends
    //     ]);
    // }

    /**
     * Delete a specific item
     */
    // public function delete()
    // {
    //     if (!$this->user) {
    //         header('Location: /login');
    //         return null;
    //     }
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = trim($_POST['id']);
    //         $memeManager = new MemeManager();
    //         $memeManager->delete((int)$id);

    //         header('Location:/vote');
    //     }
    // }
}
