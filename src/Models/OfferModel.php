<?php
    namespace App\Models;

    class OfferModel {
        private $db;

        public function __construct() {
            $this->db = new MySQLDatabase();
        }

        public function getLast3Offers() {
            return $this->db->getLast3Offers();
        }
    }
?>