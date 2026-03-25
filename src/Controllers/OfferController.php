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

            $id = $_GET['id'] ?? null;

            $keyword  = $_GET['keyword'] ?? '';
            $duration = $_GET['duration'] ?? '';
            $salary   = $_GET['salary'] ?? '';
            $skill    = $_GET['skill'] ?? '';
            $level    = $_GET['level'] ?? '';

            $isSearch = $keyword || $duration || $salary || $skill || $level;

            if ($isSearch) {
                $offers = $this->model->searchOffers($keyword, $duration, $salary, $skill, $level);
            } else if ($id) {
                $offers = $this->offerDetail($id);
                return;
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
        public function applyToOffer($id_offer) {
            if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'student') {
                header('Location: /connexion');
                return;
            }

            $cover_letter = $_POST['message'] ?? '';
            $id_student = $_SESSION['user']['id'];

            $id_cv = null;
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
                $upload_dir = __DIR__ . '/../../public/uploads/cv/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                
                $filename = uniqid() . '_' . basename($_FILES['cv']['name']);
                $filepath = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['cv']['tmp_name'], $filepath)) {
                    $id_cv = $this->model->saveCV($id_student, 'uploads/cv/' . $filename);
                }
            }

            $this->model->saveApplication($id_student, $id_offer, $cover_letter, $id_cv);
            header('Location: /offres/' . $id_offer . '?success=1');
        }
    }
?>
