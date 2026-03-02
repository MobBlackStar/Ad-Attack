<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session; 
use App\Models\Ad;
use App\Models\Comment;
// TEAM: Importing the Security Guard to verify badges.
use App\Core\Auth;

class AdController extends Controller {

    // THE EXHIBITION: Shows all ads.
    public function index() {
        $adModel = new Ad();
        $this->view('ads/gallery', [
            'title' => 'Ad-Attack | The Gallery',
            'ads'   => $adModel->findAll()
        ]);
    }

    // THE JUDGING ROOM: Shows one ad and the comments.
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();

        $ad = $adModel->find($id);
        if (!$ad) { die("This Masterpiece does not exist!"); }
        
        $comments = $commentModel->getByAd($id);

        $this->view('ads/show', [
            'title'    => 'Judging: ' . $ad->slogan,
            'ad'       => $ad,
            'comments' => $comments 
        ]);
    }

    // THE UPLOAD ROOM: Shows the submission form.
    public function submit($brief_id) {
        // TEAM: You shall not pass! (Unless you are logged in)
        Auth::requireLogin(); 
        
        $this->view('ads/submit', [
            'title' => 'Launch an Attack',
            'brief_id' => $brief_id
        ]);
    }

    // THE LOGIC: Saves the Ad.
    public function store() {
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Handshake Failed.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_FILES['ad_image'];
            $targetDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $destination = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], $destination)) {
                $adModel = new Ad();
                $adModel->createAd([
                    'brief_id'   => $_POST['brief_id'], 
                    // TEAM: Using the real ID badge now! No more fake "User 1".
                    'agency_id'  => Auth::id(), 
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $fileName 
                ]);

                Session::flash('message', 'Attack Launched Successfully! 🚀');
                header("Location: " . BASE_URL . "/ad/index");
                exit();
            }
        }
    }

    // THE FEEDBACK LOGIC: Saves comments.
    public function comment() {
        // TEAM: Only agencies with a badge can speak in the Golden Book.
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $commentModel = new Comment();
            
            // TEAM: We are signing the comment with the REAL user ID.
            $commentModel->add($_POST['ad_id'], Auth::id(), $_POST['content']);

            Session::flash('message', 'Feedback pinned to the gallery! 📌');
            header("Location: " . BASE_URL . "/ad/show/" . $_POST['ad_id']);
            exit();
        }
    }
}