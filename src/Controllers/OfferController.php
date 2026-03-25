<?php
    namespace App\Controllers;

    use App\Models\OfferModel;

    class OfferController extends Controller {
        public function __construct($templateEngine) {
            $this->model = new OfferModel();
            $this->templateEngine = $templateEngine;
        }

        public function offersList() {
            $offers = $this->model->getAllOffers();

            $keyword  = $_GET['keyword'] ?? '';
            $duration = $_GET['duration'] ?? '';
            $salary   = $_GET['salary'] ?? '';
            $skill    = $_GET['skill'] ?? '';
            $level    = $_GET['level'] ?? '';

            $isSearch = $keyword || $duration || $salary || $skill || $level;

            if ($isSearch) {
                $offers = $this->model->searchOffers($keyword, $duration, $salary, $skill, $level);
            }

            foreach ($offers as &$offer) {
                    $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
                }

            echo $this->templateEngine->render('offers.html.twig', [
                'offers' => $offers
            ]);
        }

        public function offerDetail($id) {
            $offer = $this->model->getOfferById($id);

            if (!$offer) {
                header("HTTP/1.0 404 Not Found");
                echo $this->templateEngine->render('404.html.twig');
                return;
            }

            $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];

            echo $this->templateEngine->render('offer-detail.html.twig', [
                'offer' => $offer
            ]);
        }
    }
?>
