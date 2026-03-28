<?php
    namespace App\Models;

    use PDO;
    use PDOException;

    interface IDatabase {
        public function getLast3Offers();
        public function getAllOffers();
        public function getOfferById($id);
        public function getUser($email);
        public function searchOffers($keyword, $duration, $salary, $skill, $level);
        public function hasApplied($id_student, $id_offer);
        public function saveApplication($id_student, $id_offer, $id_cv, $cover_message);
        public function saveCV($id_student, $path_cv);
        public function getUserCVs($id_student);
        public function getStats();
    }
?>