<?php
    namespace App\Controllers;

    use App\Models\MySQLDatabase;
    use App\Models\OfferModel;

    class HomeController extends Controller {
        public function __construct($templateEngine) {
            $this->model = new OfferModel();
            $this->templateEngine = $templateEngine;
        }

        public function homePage() {
            $offers = $this->model->getLast3Offers();

            foreach ($offers as &$offer) {
                $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
            }

            echo $this->templateEngine->render('home.html.twig', [
                'lastOffers' => $offers
            ]);
        }
    }
?>