<?php

namespace App\Models;

use PDO;

class CompaniesModel extends MySQLDatabase
{
    public function getCompaniesPaginated(int $limit, int $offset, string $search = ''): array
    {
        if ($search !== '') {
            $sql = "SELECT *
                    FROM companies
                    WHERE name LIKE :search
                    ORDER BY name ASC
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT *
                    FROM companies
                    ORDER BY name ASC
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countCompanies(string $search = ''): int
    {
        if ($search !== '') {
            $sql = "SELECT COUNT(*) AS total
                    FROM companies
                    WHERE name LIKE :search";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $sql = "SELECT COUNT(*) AS total FROM companies";
            $stmt = $this->db->query($sql);
        }

        $result = $stmt->fetch();

        return (int) $result['total'];
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 24ed018 (Ajout page création entreprise)
    
    public function createCompany($name, $sector, $address, $siret, $website, $description)
    {
        $sql = "INSERT INTO companies (name, sector, address, siret, website, description)
                VALUES (:name, :sector, :address, :siret, :website, :description)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'name' => $name,
            'sector' => $sector,
            'address' => $address,
            'siret' => $siret,
            'website' => $website,
            'description' => $description
        ]);
    }
    public function getCompanyById(int $idCompany)
    {
        $sql = "SELECT * FROM companies WHERE id_company = :id_company LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_company' => $idCompany
        ]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getOffersByCompanyId(int $idCompany): array
    {
        $sql = "SELECT * FROM offers WHERE id_company = :id_company";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_company' => $idCompany
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserReview(int $companyId, int $userId)
    {
        $sql = "SELECT *
                FROM company_reviews
                WHERE company_id = :company_id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':company_id' => $companyId,
            ':user_id' => $userId
        ]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createReview(int $companyId, int $userId, int $rating)
    {
        $sql = "INSERT INTO company_reviews (company_id, user_id, rating)
                VALUES (:company_id, :user_id, :rating)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':company_id' => $companyId,
            ':user_id' => $userId,
            ':rating' => $rating
        ]);
    }

    public function updateReview(int $companyId, int $userId, int $rating)
    {
        $sql = "UPDATE company_reviews
                SET rating = :rating
                WHERE company_id = :company_id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':rating' => $rating,
            ':company_id' => $companyId,
            ':user_id' => $userId
        ]);
    }

    public function getCompanyRatingData(int $companyId)
    {
        $sql = "SELECT 
                    ROUND(AVG(rating), 1) AS avg_rating,
                    COUNT(*) AS review_count
                FROM company_reviews
                WHERE company_id = :company_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':company_id' => $companyId
        ]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======
=======
>>>>>>> c923f2a (Ajout des nouveaux fichier pour la page des entreprises avec recherche et une pagination)
=======
    
    public function createCompany($name, $sector, $address, $siret, $website, $description)
    {
        $sql = "INSERT INTO companies (name, sector, address, siret, website, description)
                VALUES (:name, :sector, :address, :siret, :website, :description)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'name' => $name,
            'sector' => $sector,
            'address' => $address,
            'siret' => $siret,
            'website' => $website,
            'description' => $description
        ]);
    }
>>>>>>> d0e315a (Ajout page création entreprise)
>>>>>>> 24ed018 (Ajout page création entreprise)
}
?>