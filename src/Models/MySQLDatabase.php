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
            $sql = "SELECT offers.id_offer, offers.title, offers.duration_weeks, companies.name AS company, SUBSTRING_INDEX(GROUP_CONCAT(skills.name SEPARATOR ', '), ', ', 3) AS skills_list
                    FROM offers
                    JOIN companies ON offers.id_company = companies.id_company
                    LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer
                    LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill
                    GROUP BY offers.id_offer
                    ORDER BY offers.publication_date DESC
                    LIMIT 3";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        }

        public function getAllOffers() {
            $sql = "SELECT offers.id_offer, offers.title, offers.duration_weeks,
                        companies.name AS company,
                        SUBSTRING_INDEX(GROUP_CONCAT(skills.name SEPARATOR ', '), ', ', 3) AS skills_list
                    FROM offers
                    JOIN companies ON offers.id_company = companies.id_company
                    LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer
                    LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill
                    GROUP BY offers.id_offer
                    ORDER BY offers.publication_date DESC";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        }

        public function getOfferById($id) {
            $sql = "SELECT offers.id_offer, offers.title, offers.duration_weeks,
                        offers.publication_date, offers.salary, offers.study_level,
                        offers.description, offers.location,
                        companies.name AS company,
                        GROUP_CONCAT(skills.name SEPARATOR ', ') AS skills_list
                    FROM offers
                    JOIN companies ON offers.id_company = companies.id_company
                    LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer
                    LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill
                    WHERE offers.id_offer = :id
                    GROUP BY offers.id_offer";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        }

        public function getUser($email) {
            $sql = "SELECT users.*, 
                        CASE
                            WHEN students.id_student IS NOT NULL THEN 'student'
                            WHEN pilots.id_pilot IS NOT NULL THEN 'pilot'
                            WHEN admins.id_admin IS NOT NULL THEN 'admin'
                            ELSE 'unknown'
                        END AS user_type
                    FROM users 
                    LEFT JOIN students ON users.id_account = students.id_student
                    LEFT JOIN pilots ON users.id_account = pilots.id_pilot
                    LEFT JOIN admins ON users.id_account = admins.id_admin
                    WHERE users.email = :email";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        }
        public function searchOffers($keyword = '', $duration = '', $salary = '', $skill = '', $level = '') {
            $sql = "SELECT offers.id_offer, offers.title, offers.duration_weeks, offers.salary, offers.study_level,
                        companies.name AS company,
                        SUBSTRING_INDEX(GROUP_CONCAT(skills.name SEPARATOR ', '), ', ', 3) AS skills_list
                    FROM offers
                    JOIN companies ON offers.id_company = companies.id_company
                    LEFT JOIN offer_skills ON offer_skills.id_offer = offers.id_offer
                    LEFT JOIN skills ON skills.id_skill = offer_skills.id_skill
                    WHERE 1=1";

            $params = [];

            if ($keyword) {
                $sql .= " AND (offers.title LIKE :keyword OR skills.name LIKE :keyword)";
                $params['keyword'] = '%' . $keyword . '%';
            }
            if ($duration) {
                $sql .= " AND offers.duration_weeks = :duration";
                $params['duration'] = $duration;
            }
            if ($salary) {
                $sql .= " AND offers.salary >= :salary";
                $params['salary'] = $salary;
            }
            if ($skill) {
                $sql .= " AND skills.name LIKE :skill";
                $params['skill'] = '%' . $skill . '%';
            }
            if ($level) {
                $sql .= " AND offers.study_level = :level";
                $params['level'] = $level;
            }

            $sql .= " GROUP BY offers.id_offer ORDER BY offers.publication_date DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }
        
    }
?>