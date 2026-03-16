<?php
    namespace App\Models;

    class UserModel {
        private $db;

        public function __construct() {
            $this->db = new MySQLDatabase();
        }

        public function getUser($email) {
            return $this->db->getUser($email);
        }
    }
?>