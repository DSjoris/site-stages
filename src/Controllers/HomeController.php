<?php
namespace App\Controllers;

use App\Models\OfferModel;
use App\Models\StatsModel;

class HomeController extends Controller {
    private $offerModel;
    private $statsModel;
    protected $templateEngine;

    public function __construct($templateEngine) {
        $this->offerModel = new OfferModel();
        $this->statsModel = new StatsModel();
        $this->templateEngine = $templateEngine;
    }

    public function homePage() {
        $lastOffers = $this->offerModel->getLast3Offers();

        foreach ($lastOffers as &$offer) {
            $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
        }

        echo $this->templateEngine->render('home.html.twig', [
            'lastOffers' => $lastOffers,
            'stats' => $this->statsModel->getStats()
        ]);
    }
}
?>