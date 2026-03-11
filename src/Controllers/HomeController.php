<?php
    namespace App\Controllers;

    use App\Models\MySQLDatabase;
    use App\Models\OfferModel;

    class HomeController extends Controller {
        public function __construct($templateEngine) {
            $this->model = null;
            $this->templateEngine = $templateEngine;
        }

        public function homePage() {
            $db = new MySQLDatabase();
            $offerModel = new OfferModel($db);
            $lastsOffers = $offerModel->getLast3Offers();

            foreach($lastsOffers as &$offer) {
                $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
            }

            echo $this->templateEngine->render('home.html.twig', [
                'lastOffers' => $lastsOffers
            ]);
        }
    }
?>