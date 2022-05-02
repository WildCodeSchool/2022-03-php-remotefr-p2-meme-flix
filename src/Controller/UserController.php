<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string|null
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);

            if (empty($credentials["email"])) {
                $dataErrors[] = "Email is required";
            }

            if (empty($credentials["password"])) {
                $dataErrors[] = "Password is required";
            }

            if (isset($_POST["submit"]) && (!$dataErrors)) {
                $userManager = new UserManager();
                // On demande au UserManager de rechercher l'utilisateur en BDD à partir de l'email
                $user = $userManager->selectOneByEmail($credentials['email']);
                // Si l'utilisateur a été trouvé et si l'empreinte de son mot de passe est vérifiée...
                if ($user && password_verify($credentials['password'], $user['password'])) {
                    // ...alors on persiste l'id de notre utilisateur identifié dans la session PHP à l'index ['user_id']
                    $_SESSION['user_id'] = $user['id'];
                    // puis on le redirige sur une autre page (page d'accueil ici)
                    header('Location: /');
                    return null;
                }
            }
        }
        return $this->twig->render('Users/login.html.twig');
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
            $hash = password_hash($credentials['password'], PASSWORD_DEFAULT);
            $pattern = '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/';

            if ($hash === false && strlen($hash) <= 8 && preg_match($pattern, $hash)) {
                $dataErrors[] = "invalid password format";
            }


            if (isset($_POST["submit"]) && (!$dataErrors)) {
                $userManager = new UserManager();
                $userId = $userManager->insert($credentials);
                if ($userId) {

                    $_SESSION['user_id'] = $userId;
                    header("Location: /welcome");
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

