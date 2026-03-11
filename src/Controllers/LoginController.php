<?php
    namespace App\Controllers;

    class LoginController extends Controller {
        public function __construct($templateEngine) {
            $this->model = null;
            $this->templateEngine = $templateEngine;
        }

        public function loginPage() {
            echo $this->templateEngine->render('login.html.twig');
        }
    }
?>