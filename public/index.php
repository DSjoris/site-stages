<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    use App\Controllers\HomeController;
    use App\Controllers\AuthController;
    use App\Controllers\OfferController;
    use App\Controllers\CompaniesController;

    session_start();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
    $twig = new \Twig\Environment($loader);
    $twig->addGlobal('user', $_SESSION['user'] ?? null);
    $twig->addGlobal('session', $_SESSION);

    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    $twig->addGlobal('errors', $errors);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim($request_uri, '/');
    
<<<<<<< HEAD
=======
=======
    $twig->addGlobal('session', $_SESSION);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $route = trim($request_uri, '/');

>>>>>>> c923f2a (Ajout des nouveaux fichier pour la page des entreprises avec recherche et une pagination)
>>>>>>> 24ed018 (Ajout page création entreprise)
    switch($route) {
        case '':
        case 'accueil':
            $controller = new HomeController($twig);
            $controller->homePage();
            break;
        case 'connexion':
            $controller = new AuthController($twig);
            $controller->loginAction();
            break;
        case 'logout':
            $controller = new AuthController($twig);
            $controller->logout();
            break;
        case 'offres':
            $controller = new OfferController($twig);
            $controller->offersPage();
            break;
        case 'mentions-legales':
            echo $twig->render('legal-notices.html.twig');
            break;
        case 'postuler':
            $controller = new OfferController($twig);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->apply();
            } else {
                $controller->applyPage();
            }
            break;
        case 'wishlist':
            $controller = new OfferController($twig);
            $controller->wishlistPage();
            break;
        case 'wishlist/toggle':
            $controller = new OfferController($twig);
            $controller->toggleWishlist();
            break;
        case 'candidatures':
            $controller = new OfferController($twig);
            $controller->applicationsPage();
        case 'entreprises':
            $controller = new CompaniesController($twig);
            $controller->companiesPage();
            break;
        case 'entreprises/creation':
            $controller = new CompaniesController($twig);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->storeCompany();
            } else {
                $controller->createCompanyPage();
            }
            break;
        case 'entreprises/details':
            $controller = new CompaniesController($twig);
            $idCompany = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->companyDetailsPage($idCompany);
            break;
<<<<<<< HEAD
=======
=======
        case 'mentions-legales':
            echo $twig->render('legal-notices.html.twig');
            break;
        case 'companies':
            $controller = new CompaniesController($twig);
            $controller->companiesPage();
            break;
<<<<<<< HEAD
>>>>>>> c923f2a (Ajout des nouveaux fichier pour la page des entreprises avec recherche et une pagination)
=======
        case 'companies/create':
            $controller = new CompaniesController($twig);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->storeCompany();
            } else {
                $controller->createCompanyPage();
            }
            break;
<<<<<<< HEAD
>>>>>>> d0e315a (Ajout page création entreprise)
>>>>>>> 24ed018 (Ajout page création entreprise)
        default:
            header("HTTP/1.0 404 Not Found");
            echo $twig->render('404.html.twig');
            break;
    }
=======
       case (preg_match('#^companies/details/(\d+)$#', $route, $matches) ? true : false):
            $controller = new CompaniesController($twig);
            $controller->companyDetailsPage((int)$matches[1]);
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            echo $twig->render('404.html.twig');
            break;    
        }
>>>>>>> 41013a5 (Ajout de la page company-details pour pouvoir voir chaque company individuellement)
?>