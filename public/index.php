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

    session_start();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
    $twig = new \Twig\Environment($loader);
    $twig->addGlobal('user', $_SESSION['user'] ?? null);

    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    $twig->addGlobal('errors', $errors);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = ltrim($request_uri, '/');

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
        default:
            header("HTTP/1.0 404 Not Found");
            echo $twig->render('404.html.twig');
            break;
    }
?>