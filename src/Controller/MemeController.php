<?php

namespace App\Controller;

class MemeController extends AbstractController
{
    /**
     * Display home page
     */
    public function createMeme(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        }
        return $this->twig->render('meme/create.html.twig');
    }
}
