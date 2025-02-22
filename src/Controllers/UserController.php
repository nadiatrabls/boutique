<?php
namespace Boutique\Controllers;

use Boutique\Models\UserModel;

class UserController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        // ✅ Affichage de la page de login
        $this->render('login');
    }

    /**
     * Vérifie les identifiants de l'utilisateur et le connecte
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);

            // ✅ Vérification du mot de passe
            if ($user && password_verify($password, $user->password)) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: index.php?url=checkout'); // 🔥 Redirection vers la page checkout
                exit;
            } else {
                $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
                $this->render('login', ['erreur' => $erreur]);
            }
        }
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php?url=login');
        exit;
    }



    /**
     * Affiche le formulaire d'inscription
     */
    public function register()
    {
        $this->render('register');
    }

    /**
     * Gère l'inscription de l'utilisateur
     */
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
            $confirmPassword = htmlspecialchars(trim($_POST['confirm_password']));

            // ✅ Vérification des champs vides
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $erreur = "Tous les champs doivent être remplis.";
                $this->render('register', ['erreur' => $erreur]);
                return;
            }

            // ✅ Vérification de la confirmation du mot de passe
            if ($password !== $confirmPassword) {
                $erreur = "Les mots de passe ne correspondent pas.";
                $this->render('register', ['erreur' => $erreur]);
                return;
            }

            // ✅ Vérification de l'existence de l'utilisateur
            $userModel = new UserModel();
            if ($userModel->getUserByUsername($username)) {
                $erreur = "Ce nom d'utilisateur est déjà pris.";
                $this->render('register', ['erreur' => $erreur]);
                return;
            }

            // ✅ Vérification de l'existence de l'email
            if ($userModel->getUserByEmail($email)) {
                $erreur = "Cet email est déjà utilisé.";
                $this->render('register', ['erreur' => $erreur]);
                return;
            }

            // ✅ Hashage du mot de passe et enregistrement de l'utilisateur
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userModel->createUser($username, $email, $hashedPassword);

            $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            $this->render('register', ['success' => $success]);
        }
    }
}
