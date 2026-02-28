<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ad;
use App\Models\Comment;
use App\Core\Session; 
use App\Core\Auth; // Architect tool for security

// TEAM - Sarra : I'm the Gallery Curator! I handle the masterpieces and the feedback.
class AdController extends Controller {

    // TEAM : Display the whole gallery
    public function index() {
        $adModel = new Ad();
        $allAds = $adModel->findAll();

        $this->view('ads/gallery', [
            'title' => 'Ad-Attack | The Gallery',
            'ads'   => $allAds
        ]);
    }

    // TEAM : Show ONE specific masterpiece and its comments
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();

        $ad = $adModel->find($id);
        if (!$ad) { die("Masterpiece not found!"); }
        
        $comments = $commentModel->getByAd($id);

        $this->view('ads/show', [
            'title'    => 'Judging: ' . $ad->slogan,
            'ad'       => $ad,
            'comments' => $comments
        ]);
    }

    // TEAM : Show the "Upload" room
    public function submit($brief_id) {
        // Only agencies can attack!
        // Auth::requireLogin(); 
        
        $this->view('ads/submit', [
            'title' => 'Launch an Attack',
            'brief_id' => $brief_id
        ]);
    }

    // TEAM : Physically save the Ad to the Warehouse (Database)
    public function store() {
        // SECURITY: Check the Secret Handshake (CSRF)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Handshake failed.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_FILES['ad_image'];
            // Architect path logic
            $targetDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $destination = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], $destination)) {
                $adModel = new Ad();
                $adModel->createAd([
                    'brief_id'   => $_POST['brief_id'], 
                    'agency_id'  => 1, // Temporarily 1 until Donyes finishes Login
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $fileName // We only save the NAME in the DB
                ]);

                Session::flash('message', 'Attack Launched Successfully! 🚀');
                header("Location: " . BASE_URL . "/ad/index");
                exit();
            } else {
                die("Upload failed to: " . $destination);
            }
        }
    }

    // TEAM : Add a comment to the Golden Book
    public function comment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ad_id = $_POST['ad_id'];
            $commentModel = new Comment();
            
            $commentModel->add($ad_id, 1, $_POST['content']);

            Session::flash('message', 'Your feedback has been pinned! 📌');
            header("Location: " . BASE_URL . "/ad/show/" . $ad_id);
            exit();
        }
    }
}