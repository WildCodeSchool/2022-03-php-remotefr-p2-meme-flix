<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(string $redirect = "/"): string|null
    {
        $dataErrors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            $credentials = array_map('htmlentities', $_POST);


            if (empty($credentials["email"])) {
                $dataErrors[] = "Email is required";
            }

            if (empty($credentials["password"])) {
                $dataErrors[] = "Password is required";
            }
            if (empty($dataErrors)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($credentials['email']);

                if ($user && password_verify($credentials['password'], $user['password']) && (!$dataErrors)) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: ' . $redirect);
                    return null;
                }
            }
        }
        return $this->twig->render('Users/login.html.twig', [
            'dataErrors' => $dataErrors
        ]);
    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        header('Location: /');
        return null;
    }

    public function register(): string|null
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // @todo make some controls and if errors send them to the view
            $credentials = array_map('trim', $_POST);
            $credentials = array_map('htmlentities', $_POST);
            $dataErrors = [];

            if (empty($credentials["pseudo"])) {
                $dataErrors[] = "Pseudo is required";
            }

            if (empty($credentials["email"])) {
                $dataErrors[] = "Email is required";
            }

            if (!filter_var($credentials["email"], FILTER_VALIDATE_EMAIL)) {
                $dataErrors[] = "invalid email format";
            }

            if (!preg_match('/\w/', $credentials['password'])) {
                $dataErrors[] = "ne doit contenir que des lettres ou chiffres";
            }

            if (strlen($credentials['password']) < 8) {
                $dataErrors[] = "Minimun 8 Caractères";
            }

            if (empty($dataErrors)) {
                $userManager = new UserManager();
                $userId = $userManager->insert($credentials);
                if ($userId) {
                    return $this->login("/welcome");
                }
            }
        }
        return $this->twig->render('Users/register.html.twig');
    }


    public function welcome(): string
    {

        return $this->twig->render('Users/welcome.html.twig');
    }
}
