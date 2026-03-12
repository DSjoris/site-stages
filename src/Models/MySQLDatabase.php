<?php
    namespace App\Models;

    use PDO;
    use PDOException;

    class MySQLDatabase implements IDatabase {
        private $db;

        public function __construct() {
            if($this->db === null) {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASSWORD'];
            
                try {
                    $this->db = new PDO(
                        "mysql:host=$host;dbname=$dbname;charset=utf8",
                        $user,
                        $password,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                        ]
                    );
                } catch (PDOException $e) {
                    die("Erreur de connexion : " . $e->getMessage());
                }
            }

            return $this->db;
        }

        public function getLast3Offers() {
            $sql = "SELECT offers.title, offers.duration_weeks, companies.name AS company, SUBSTRING_INDEX(GROUP_CONCAT(skills.name SEPARATOR ', '), ', ', 3) AS skills_list FROM offers JOIN companies ON offers.id_company = companies.id_company LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill GROUP BY offers.id_offer ORDER BY offers.publication_date DESC LIMIT 3";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        }
    }
?>