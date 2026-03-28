<?php
    namespace App\Models;

    class StatsModel {
        private $db;

        public function __construct() {
            $this->db = new MySQLDatabase();
        }

        public function getStats() {
            return $this->db->getStats();
        }
    }
?>