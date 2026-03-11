<?php
    namespace App\Models;

    use PDO;
    use PDOException;

    class MySQLDatabase implements IDatabase {
        private $connection;

        public function __construct() {
            if($this->connection === null) {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASSWORD'];
            
                try {
                    $this->connection = new PDO(
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

            return $this->connection;
        }

        public function getConnection() {
            return $this->connection;
        }
    }
?>