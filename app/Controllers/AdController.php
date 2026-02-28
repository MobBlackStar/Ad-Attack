<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ad;
use App\Models\Comment;
use App\Core\Session; // TEAM : On en a besoin pour le message de succès !

// TEAM - Sarra : Je gère maintenant la réception des fichiers et des commentaires !
class AdController extends Controller {

    // TEAM : Affiche toutes les pubs
    public function index() {
        $adModel = new Ad();
        $allAds = $adModel->findAll();

        $this->view('ads/gallery', [
            'title' => 'La Galerie des Guerilleros',
            'ads'   => $allAds
        ]);
    }

    // TEAM : Affiche UNE pub avec ses commentaires
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();

        $ad = $adModel->find($id);
        $comments = $commentModel->getByAd($id);

        $this->view('ads/show', [
            'title'    => 'Détails de la pépite',
            'ad'       => $ad,
            'comments' => $comments
        ]);
    }

    // TEAM : Affiche le formulaire d'envoi de pub
    public function submit() {
        $this->view('ads/submit', ['title' => 'Submit your Ad']);
    }

    // TEAM : Enregistre la pub et l'image
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_FILES['ad_image'];
            $targetDir = "assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], "../public/" . $targetFilePath)) {
                $adModel = new Ad();
                $adModel->createAd([
                    'brief_id'   => 1, 
                    'agency_id'  => 1, 
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $targetFilePath
                ]);
                echo "<h1>Succès !</h1><p>Ton Ad est en ligne.</p><a href='index.php?url=ad/index'>Voir la galerie</a>";
            } else {
                echo "Erreur lors de l'upload.";
            }
        }
    }

    // ======================================================
    // TEAM - Sarra : VOICI LA FONCTION QUI MANQUAIT !
    // ======================================================
    public function comment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $ad_id = $_POST['ad_id'];
            $content = $_POST['content'];
            $agency_id = 1; // Temporaire en attendant le login de Donyes

            $commentModel = new Comment();
            
            // On enregistre l'avis dans la base de données
            $commentModel->add($ad_id, $agency_id, $content);

            // On met un petit message vert pour dire que c'est bon
            Session::flash('success', 'Ton commentaire a été ajouté !');

            // On renvoie l'utilisateur sur la page de la pub
            header("Location: index.php?url=ad/show/" . $ad_id);
            exit();
        }
    }
} // Fin de la classe