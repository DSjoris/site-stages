<?php
    namespace App\Models;

    use PDO;
    use PDOException;

    interface IDatabase {
        public function getLast3Offers();
        public function getAllOffers();
        public function getOfferById($id);
        public function getUser($email);
    }
?>