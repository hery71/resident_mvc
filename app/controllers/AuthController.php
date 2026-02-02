<?php

class AuthController
{
    public function login()
    {
        // Si déjà connecté → accueil
        if (Auth::check()) {
            header("Location: /");
            exit;
        }

        $token = Auth::generateToken();
        require __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate()
    {
        if (!Auth::checkToken($_POST['token'] ?? '')) {
            http_response_code(403);
            exit('Token CSRF invalide');    
        }

        $login    = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($login === '' || $password === '') {
            $_SESSION['error'] = "Merci de remplir tous les champs";
            header("Location: /auth/login");
            exit;
        }

        $model = new UserModel();
        $user  = $model->findByLoginOrEmail($login);

        if (!$user) {
           $_SESSION['error'] = "Mauvaise combinaison login/mot de passe";
            header("Location: /auth/login");
            exit;
        }

        // 🔐Hach
        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Mauvaise combinaison login/mot de passe";
            header("Location: /auth/login");
            exit;
        }
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            //$model->updatePassword($user['Id'], $newHash);
        }

        Auth::login($user);
        header("Location: /resident");
        exit;
    }

    public function logout()
    {
        Auth::logout();
        header("Location: /auth/login");
        exit;
    }
}
