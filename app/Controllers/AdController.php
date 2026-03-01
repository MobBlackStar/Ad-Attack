<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session; 
use App\Core\Auth; // Fedi: The Security Guard!
use App\Models\Ad;
use App\Models\Comment;

// TEAM - Sarra : I am the Gallery Curator! I handle the masterpieces and the feedback.
class AdController extends Controller {

    // TEAM : Display the whole gallery
    public function index() {
        $adModel = new Ad();
        $allAds = $adModel->findAll();

        $this->view('ads/gallery',[
            'title' => 'Ad-Attack | The Gallery',
            'ads'   => $allAds
        ]);
    }

    // TEAM : Show ONE specific masterpiece and its comments
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();

        $ad = $adModel->find($id);
        if (!$ad) { die("Ad not found!"); }
        
        // TEAM: This is where we grab the specific comments for this Ad
        $comments = $commentModel->getByAd($id); 

        $this->view('ads/show', [
            'title'    => 'Reviewing: ' . $ad->slogan,
            'ad'       => $ad,
            'comments' => $comments // TEAM: Make sure this variable name matches the View!
        ]);
    }

    // TEAM : Show the "Upload" room (Needs Brief ID to know which challenge we are answering)
    public function submit($brief_id) {
        // Fedi: Lock this room! Only logged-in agencies can submit ads.
        // Auth::requireLogin(); // Uncomment when Donyes finishes Login
        
        $this->view('ads/submit',[
            'title' => 'Launch an Attack',
            'brief_id' => $brief_id
        ]);
    }

    // TEAM : Physically save the Ad to the server and the Database
    public function store() {
        // SECURITY: Check the Secret Handshake (CSRF)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Handshake failed. Are you a hacker?");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_FILES['ad_image'];
            // Architect path logic to save in public/assets/uploads/
            $targetDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $destination = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], $destination)) {
                $adModel = new Ad();
                $adModel->createAd([
                    'brief_id'   => $_POST['brief_id'], 
                    'agency_id'  => 1, // Fake ID until Login works
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $fileName 
                ]);

                Session::flash('message', 'Attack Launched Successfully! 🚀');
                header("Location: " . BASE_URL . "/ad/index");
                exit();
            } else {
                die("Upload failed.");
            }
        }
    }

    // TEAM : Sarra, I moved this here from the Model. Controllers handle $_POST!
    public function comment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ad_id = $_POST['ad_id'];
            $commentModel = new Comment();
            
            // Fake agency ID = 1 for now
            $commentModel->add($ad_id, 1, $_POST['content']);

            Session::flash('message', 'Your feedback has been pinned! 📌');
            header("Location: " . BASE_URL . "/ad/show/" . $ad_id);
            exit();
        }
    }
}