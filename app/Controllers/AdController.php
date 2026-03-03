<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session; 
use App\Models\Ad;
use App\Models\Comment;
use App\Core\Auth; // Le garde du corps de Fedi

class AdController extends Controller {

    // Affiche la galerie
    public function index() {
        $adModel = new Ad();
        $this->view('ads/gallery', [
            'title' => 'Ad-Attack | The Gallery',
            'ads'   => $adModel->findAll()
        ]);
    }

    // Affiche une pub avec ses commentaires
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();

        $ad = $adModel->find($id);
        if (!$ad) { die("Cette œuvre n'existe pas !"); }
        
        $comments = $commentModel->getByAd($id);

        $this->view('ads/show', [
            'title'    => 'Judging: ' . $ad->slogan,
            'ad'       => $ad,
            'comments' => $comments 
        ]);
    }

    // Affiche le formulaire (Ne pas oublier cette fonction !)
    public function submit($brief_id = 1) {
        $this->view('ads/submit', [
            'title'    => 'Submit your Ad',
            'brief_id' => $brief_id
        ]);
    }

    // TEAM - Sarra : Voici l'unique version de STORE (Enregistrement)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // On vérifie la sécurité CSRF de Fedi
            // Si tu n'as pas encore mis le jeton dans ton HTML, on peut commenter cette ligne temporairement
            /*
            if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
                die("Erreur de sécurité : Jeton invalide.");
            }
            */

            $image = $_FILES['ad_image'];
            $targetDir = "assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], "../public/" . $targetFilePath)) {
                
                $adModel = new Ad();
                
                // TEAM : On enregistre avec l'ID réel si connecté, sinon ID 1
                $agency_id = Session::get('user_id') ?? 1;

                $adModel->createAd([
                    'brief_id'   => $_POST['brief_id'] ?? 1,
                    'agency_id'  => $agency_id,
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $targetFilePath
                ]);

                Session::flash('success', 'L\'attaque est lancée ! 🚀');
                header("Location: index.php?url=ad/index");
                exit();
            
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        }
    }

    // TEAM : Enregistre un commentaire
    public function comment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $commentModel = new Comment();
            
            $ad_id = $_POST['ad_id'];
            $agency_id = Session::get('user_id') ?? 1;

            $commentModel->add($ad_id, $agency_id, $_POST['content']);

            Session::flash('success', 'Avis ajouté au Livre d\'Or ! 📌');
            header("Location: index.php?url=ad/show/" . $ad_id);
            exit();
        }
    }
}