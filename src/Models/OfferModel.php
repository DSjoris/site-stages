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

        public function getAllOffers() {
            return $this->db->getAllOffers();
        }

        public function getOfferById($id) {
            return $this->db->getOfferById($id);
        }

        public function searchOffers($keyword = '', $duration = '', $salary = '', $skill = '', $level = '') {
            return $this->db->searchOffers($keyword, $duration, $salary, $skill, $level);
        }
        public function saveApplication($id_student, $id_offer, $cover_letter, $id_cv) {
            return $this->db->saveApplication($id_student, $id_offer, $cover_letter, $id_cv);
        }

        public function saveCV($id_student, $chemin_cv) {
            return $this->db->saveCV($id_student, $chemin_cv);
        }
    }
?>