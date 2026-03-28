<?php
    namespace App\Controllers;

    use App\Models\UserModel;

    class AuthController extends Controller {
        public function __construct($templateEngine) {
            $this->model = new UserModel();
            $this->templateEngine = $templateEngine;
        }

        public function loginAction() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $this->login();
            } else {
                echo $this->templateEngine->render('login.html.twig');
            }
        }

        public function login() {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if(!isset($email) || empty($email)) {
                echo $this->templateEngine->render('login.html.twig', ['error' => 'Email invalide.']);
            } else if(!isset($password) || empty($password)) {
                echo $this->templateEngine->render('login.html.twig', ['error' => 'Mot de passe invalide.']);
            }

            $user = $this->model->getUser($email);
            
            if(password_verify($password, $user["password"])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id_account'],
                    'email' => $user['email'],
                    'last_name' => $user['last_name'],
                    'first_name' => $user['first_name'],
                    'phone' => $user['phone'],
                    'user_type' => $user['user_type']
                ];
                header('Location: /accueil');
            } else {
                echo $this->templateEngine->render('login.html.twig', ['error' => 'Email ou mot de passe incorrect.']);
            }
        }

        public function logout() {
            session_start();
            $_SESSION = [];
            session_destroy();
            header('Location: /connexion');
        }
    }
?>