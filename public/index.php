<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Controllers\HomeController;
    use App\Controllers\LoginController;

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
    $twig = new \Twig\Environment($loader);

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
            $controller = new LoginController($twig);
            $controller->loginPage();
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