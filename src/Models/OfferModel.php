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

        public function hasApplied($id_student, $id_offer) {
            return $this->db->hasApplied($id_student, $id_offer);
        }

        public function saveApplication($id_student, $id_offer, $id_cv, $cover_message) {
            return $this->db->saveApplication($id_student, $id_offer, $id_cv, $cover_message);
        }

        public function saveCV($id_student, $chemin_cv) {
            return $this->db->saveCV($id_student, $chemin_cv);
        }

        public function getUserCVs($id_student) {
            return $this->db->getUserCVs($id_student);
        }
        public function isInWishlist($id_student, $id_offer) {
            return $this->db->isInWishlist($id_student, $id_offer);
        }

        public function toggleWishlist($id_student, $id_offer) {
            return $this->db->toggleWishlist($id_student, $id_offer);
        }

        public function getUserWishlist($id_student) {
            return $this->db->getUserWishlist($id_student);
        }

        public function getUserApplications($id_student) {
            return $this->db->getUserApplications($id_student);
        }
    }
?>