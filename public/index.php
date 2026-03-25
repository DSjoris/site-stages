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
    $twig->addGlobal('session', $_SESSION);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = '/';
    $route = trim($request_uri, '/');

    $routes = [
        ['GET', '', HomeController::class, 'homePage'],
        ['GET', 'accueil', HomeController::class, 'homePage'],
        ['GET', 'connexion', AuthController::class, 'loginAction'],
        ['GET', 'logout', AuthController::class, 'logout'],
        ['GET', 'offres', OfferController::class, 'offersList'],
        ['GET', 'mentions-legales', null, 'legal-notices.html.twig'],

        // dynamiques
        ['GET', 'offres/{id}', OfferController::class, 'offerDetail'],
        ['GET', 'postuler/{id}', OfferController::class, 'applyToOffer'],
    ];

    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($routes as [$httpMethod, $path, $controllerClass, $action]) {

        if ($method !== $httpMethod) continue;

        // transforme {id} → regex
        $pattern = preg_replace('#\{(\w+)\}#', '([0-9]+)', $path);
        $pattern = "#^$pattern$#";

        if (preg_match($pattern, $route, $matches)) {

            array_shift($matches); // enlève le match complet

            // cas page statique
            if ($controllerClass === null) {
                echo $twig->render($action);
                exit;
            }

            $controller = new $controllerClass($twig);
            call_user_func_array([$controller, $action], $matches);
            exit;
        }
    }

    // 404
    header("HTTP/1.0 404 Not Found");
    echo $twig->render('404.html.twig');
?>