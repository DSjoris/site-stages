<?php

namespace App\Controllers;

use App\Models\CompaniesModel;

class CompaniesController extends Controller
{
    public function __construct($templateEngine)
    {
        $this->model = new CompaniesModel();
        $this->templateEngine = $templateEngine;
    }

    public function companiesPage()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if ($page < 1) {
            $page = 1;
        }

        $limit = 10;
        $offset = ($page - 1) * $limit;

        $companies = $this->model->getCompaniesPaginated($limit, $offset, $search);
        $totalCompanies = $this->model->countCompanies($search);
        $totalPages = (int) ceil($totalCompanies / $limit);

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6d83437 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
>>>>>>> 401ad78 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
=======
>>>>>>> 2488289 (fix: corrections après rebase)
        foreach ($companies as &$company) {
            $company['ville'] = $this->extractVille($company['address']);
        }

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> c923f2a (Ajout des nouveaux fichier pour la page des entreprises avec recherche et une pagination)
=======
>>>>>>> 6d83437 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
>>>>>>> 401ad78 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
=======
>>>>>>> 2488289 (fix: corrections après rebase)
        echo $this->templateEngine->render('companies.html.twig', [
            'companies' => $companies,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d0e315a (Ajout page création entreprise)
>>>>>>> 24ed018 (Ajout page création entreprise)
=======
>>>>>>> 2488289 (fix: corrections après rebase)

    public function createCompanyPage()
    {
        echo $this->templateEngine->render('companies-create.html.twig', [
            'errors' => [],
            'old' => []
        ]);
    }

    public function storeCompany()
    {
        $name = trim($_POST['name'] ?? '');
        $sector = trim($_POST['sector'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $siret = trim($_POST['siret'] ?? '');
        $website = trim($_POST['website'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $fields = [
            'name' => "Le nom est obligatoire",
            'sector' => "Le secteur est obligatoire",
            'address' => "L'adresse est obligatoire",
            'siret' => "Le SIRET est obligatoire",
            'website' => "Le site web est obligatoire",
            'description' => "La description est obligatoire"
        ];

        $errors = [];

        foreach ($fields as $field => $message) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = $message;
            }
        }

        if (!preg_match('/^\d{14}$/', $siret)) {
            $errors[] = "Le numéro de SIRET doit contenir exactement 14 chiffres.";
        }

        if ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
            $errors[] = "L'URL du site web n'est pas valide.";
        }
        $description = trim($_POST['description'] ?? '');

        $errors = [];
        $allowedSectors = ['primaire', 'secondaire', 'tertiaire'];

        if ($name === '') {
            $errors[] = "Le nom de l'entreprise est obligatoire.";
        }

        if (!in_array($sector, $allowedSectors, true)) {
            $errors[] = "Le secteur sélectionné est invalide.";
        }

        if ($address === '') {
            $errors[] = "L'adresse est obligatoire.";
        }

        if (!preg_match('/^\d{14}$/', $siret)) {
            $errors[] = "Le numéro de SIRET doit contenir exactement 14 chiffres.";
        }

        if ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
            $errors[] = "L'URL du site web n'est pas valide.";
        }

        if (!empty($errors)) {
            echo $this->templateEngine->render('companies-create.html.twig', [
                'errors' => $errors,
                'old' => [
                    'name' => $name,
                    'sector' => $sector,
                    'address' => $address,
                    'siret' => $siret,
                    'website' => $website,
                    'description' => $description
                ]
            ]);
            return;
        }

        $this->model->createCompany(
            $name,
            $sector,
            $address,
            $siret,
            $website,
            $description
        );

        header('Location: /entreprises');
        exit;
    }

    public function companyDetailsPage(int $idCompany)
    {
        if ($idCompany <= 0) {
            http_response_code(404);
            echo "Entreprise introuvable.";
            return;
        }

        $company = $this->model->getCompanyById($idCompany);
        $offers = $this->model->getOffersByCompanyId($idCompany);
        $ratingData = $this->model->getCompanyRatingData($idCompany);

        if (!$company) {
            http_response_code(404);
            echo "Entreprise introuvable.";
            return;
        }

        $userReview = null;

        if (isset($_SESSION['user']['id'])) {
            $userReview = $this->model->getUserReview($idCompany, (int) $_SESSION['user']['id']);
        }

        echo $this->templateEngine->render('companies-details.html.twig', [
            'company' => $company,
            'offers' => $offers,
            'ratingData' => $ratingData,
            'userReview' => $userReview
        ]);
    }

    private function extractVille($adress)
    {
        if (!$adress) {
            return '';
        }

        if (preg_match('/\b\d{5}\s+(.+)$/', $adress, $matches)) {
            return $matches[1];
        }

        return $adress;
    }

    public function rateCompany(int $idCompany)
    {
        if (
            !isset($_SESSION['user']) ||
            !isset($_SESSION['user']['user_type']) ||
            !in_array($_SESSION['user']['user_type'], ['admin', 'pilote'], true)
        ) {
            http_response_code(403);
            echo "Accès interdit.";
            return;
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        $rating = (int) ($_POST['rating'] ?? 0);

        if ($idCompany <= 0 || $userId <= 0) {
            http_response_code(400);
            echo "Requête invalide.";
            return;
        }

        if ($rating < 1 || $rating > 5) {
            http_response_code(400);
            echo "Note invalide.";
            return;
        }

        $company = $this->model->getCompanyById($idCompany);

        if (!$company) {
            http_response_code(404);
            echo "Entreprise introuvable.";
            return;
        }

        $existingReview = $this->model->getUserReview($idCompany, $userId);

        if ($existingReview) {
            $this->model->updateReview($idCompany, $userId, $rating);
        } else {
            $this->model->createReview($idCompany, $userId, $rating);
        }

        header('Location: /companies/details/' . $idCompany);
        exit;
    }
}
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
}
?>
>>>>>>> c923f2a (Ajout des nouveaux fichier pour la page des entreprises avec recherche et une pagination)
=======
        $this->model->createCompany($name, $sector, $city, $description);
=======
>>>>>>> c9115d4 (amélioration de la création d'entreprise et amélioration de la liste d'entreprises avec les adresses opérationnel)

        header('Location: /companies');
        exit;
    }
<<<<<<< HEAD
}
>>>>>>> d0e315a (Ajout page création entreprise)
<<<<<<< HEAD
>>>>>>> 24ed018 (Ajout page création entreprise)
=======
=======
    public function companyDetailsPage(int $idCompany)
    {
        if ($idCompany <= 0) {
            http_response_code(404);
            echo "Entreprise introuvable.";
            return;
        }

        $company = $this->model->getCompanyById($idCompany);
        $offers = $this->model->getOffersByCompanyId($idCompany);

        if (!$company) {
            http_response_code(404);
            echo "Entreprise introuvable.";
            return;
        }

        echo $this->templateEngine->render('companies-details.html.twig', [
            'company' => $company,
            'offers' => $offers
        ]);
    }
<<<<<<< HEAD
}
>>>>>>> 41013a5 (Ajout de la page company-details pour pouvoir voir chaque company individuellement)
<<<<<<< HEAD
>>>>>>> fa7e88c (Ajout de la page company-details pour pouvoir voir chaque company individuellement)
=======
=======

    private function extractVille($adress)
    {
        if (!$adress) {
            return '';
        }

        if (preg_match('/\b\d{5}\s+(.+)$/', $adress, $matches)) {
            return $matches[1];
        }

        return $adress;
    }
}
>>>>>>> 6d83437 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
>>>>>>> 401ad78 (modification des cards entreprise : adresse -> ville, ajout du bouton modifier pour admins/pilotes)
=======
>>>>>>> 2488289 (fix: corrections après rebase)
