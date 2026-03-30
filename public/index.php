<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    use public\hash;
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
    

    $twig->addGlobal('session', $_SESSION);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $route = trim($request_uri, '/');

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
            break;
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
        case 'mentions-legales':
            echo $twig->render('legal-notices.html.twig');
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            echo $twig->render('404.html.twig');
            break;    
        }
