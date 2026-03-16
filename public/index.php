<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    use App\Controllers\HomeController;
    use App\Controllers\AuthController;

    session_start();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
    $twig = new \Twig\Environment($loader);
    $twig->addGlobal('session', $_SESSION);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = '/';
    $route = str_replace($basePath, '', $request_uri);
    $route = trim($route, '/');

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
        case 'mentions-legales':
            echo $twig->render('legal-notices.html.twig');
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            echo $twig->render('404.html.twig');
            break;

    }
?>