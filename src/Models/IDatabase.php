<?php
    namespace App\Models;

    use PDO;
    use PDOException;

    interface IDatabase {
        public function getLast3Offers();
    }
?>