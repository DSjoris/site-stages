<?php
    namespace App\Controllers;

    use App\Models\MySQLDatabase;

    class ContactController extends Controller {
        private $db;

        public function __construct($templateEngine) {
            $this->templateEngine = $templateEngine;
            $this->db = new MySQLDatabase();
        }

        public function contactPage() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $message = $_POST['message'] ?? '';

                $this->db->saveContact($name, $email, $phone, $message);
                echo $this->templateEngine->render('contact.html.twig', ['success' => true]);
            } else {
                echo $this->templateEngine->render('contact.html.twig');
            }
        }
    }
?>