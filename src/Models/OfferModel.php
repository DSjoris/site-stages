<?php
    namespace App\Models;

    class OfferModel {
        private $db;

        public function __construct(IDatabase $database) {
            $this->db = $database->getConnection();
        }

        public function getLast3Offers() {
            $sql = "SELECT offers.title, offers.duration_weeks, companies.name AS company, SUBSTRING_INDEX(GROUP_CONCAT(skills.name SEPARATOR ', '), ', ', 3) AS skills_list FROM offers JOIN companies ON offers.id_company = companies.id_company LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill GROUP BY offers.id_offer ORDER BY offers.publication_date DESC LIMIT 3";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        }
    }
?>