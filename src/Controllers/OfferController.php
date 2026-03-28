<?php
    namespace App\Controllers;

    use App\Models\OfferModel;

    class OfferController extends Controller {
        public function __construct($templateEngine) {
            $this->model = new OfferModel();
            $this->templateEngine = $templateEngine;
        }

        // Page des offres
        public function offersPage() {
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
                $offers = $this->offerPage($id);
                return;
            }

            foreach ($offers as &$offer) {
                    $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
                }

            echo $this->templateEngine->render('offers.html.twig', [
                'offers' => $offers
            ]);
        }

        // Page d'une offre
        public function offerPage($id) {
            $offer = $this->model->getOfferById($id);

            if (!$offer) {
                header("HTTP/1.0 404 Not Found");
                echo $this->templateEngine->render('404.html.twig');
                return;
            }

            $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];

            echo $this->templateEngine->render('offer.html.twig', [
                'offer' => $offer,
                'alreadyApplied' => isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'student' && $this->model->hasApplied($_SESSION['user']['id'], $id)
            ]);
        }

        // Page de postulation à une offre
        public function applyPage() {
            if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'student') {
                header('Location: /connexion');
                return;
            }

            $id_offer = $_GET['id'] ?? null;
            if (!$id_offer) {
                header('Location: /offres');
                return;
            }

            $offer = $this->model->getOfferById($id_offer);
            if (!$offer) {
                header("HTTP/1.0 404 Not Found");
                echo $this->templateEngine->render('404.html.twig');
                return;
            }

            $offer['skills'] = $offer['skills_list'] ? explode(', ', $offer['skills_list']) : [];
            $cvs = $this->getUserCVs($_SESSION['user']['id']);

            foreach ($cvs as &$cv) {
                $filename = basename($cv['path_cv']);
                $array = explode('_', $filename);
                array_shift($array);
                $cv['filename'] = implode('_', $array);
            }

            echo $this->templateEngine->render('postulate.html.twig', [
                'offer' => $offer,
                'cvs' => $cvs
            ]);
        }

        // Fonction: postuler à une offre
        public function apply() {
            if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'student') {
                header('Location: /connexion');
                return;
            }

            $id_offer = $_GET['id'] ?? null;
            if (!$id_offer) {
                header('Location: /offres');
                return;
            }

            $cover_message = $_POST['message'] ?? '';
            $id_student = $_SESSION['user']['id'];
            $id_cv_selected = $_POST['id_cv'] ?? null;

            if($this->model->hasApplied($id_student, $id_offer)) {
                $_SESSION['errors'][] = "Vous avez déjà postulé à cette offre";
                header('Location: /postuler?id=' . $id_offer);
                return;
            }

            if($id_cv_selected && $id_cv_selected !== 'none') {
                $this->model->saveApplication($id_student, $id_offer, $id_cv_selected, $cover_message);
                header('Location: /offres?id=' . $id_offer);
            } else if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
                    $file = $_FILES['cv'];

                    if ($file['size'] > 5242880) {
                        $_SESSION['errors'][] = "Le fichier est trop volumineux (max 5 Mo)";
                        header('Location: /postuler?id=' . $id_offer);
                        exit;
                    }

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $file['tmp_name']);
                    finfo_close($finfo);

                    if ($mime !== 'application/pdf') {
                        $_SESSION['errors'][] = "Le fichier doit être au format PDF";
                        header('Location: /postuler?id=' . $id_offer);
                        exit;
                    }

                    $upload_dir = __DIR__ . '/../../public/uploads/cv/';
                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                    $filename = uniqid() . '_' . $file['name'];
                    $filepath = $upload_dir . $filename;

                    if (move_uploaded_file($file['tmp_name'], $filepath)) {
                        $id_cv = $this->model->saveCV($id_student, 'uploads/cv/' . $filename);
                        $this->model->saveApplication($id_student, $id_offer, $id_cv, $cover_message);
                        header('Location: /offres?id=' . $id_offer);
                    }
                }
            }

        // Fonction: obtenir les CV
        public function getUserCVs() {
            if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'student') {
                header('Location: /connexion');
                return;
            }

            $id_student = $_SESSION['user']['id'];
            return $this->model->getUserCVs($id_student);
        }
    }
?>
