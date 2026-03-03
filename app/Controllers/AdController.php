<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session; 
use App\Models\Ad;
use App\Models\Comment;
use App\Models\Vote; // TEAM: Make sure we invite the Vote worker to the meeting!
use App\Core\Auth; 

class AdController extends Controller {

    // TEAM: Sarra - The Ad Shredder. 
    // Only the artist who made the Ad (or the Overlord) can delete it.
    public function delete($id) {
        \App\Core\Auth::requireLogin();
        $model = new Ad();
        $ad = $model->find($id);

        if ($ad && ($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1)) {
            $model->delete($id);
            \App\Core\Session::flash('message', 'Masterpiece removed from gallery.');
        }
        header('Location: ' . BASE_URL . '/ad/index');
        exit();
    }

    // THE EXHIBITION: Shows all ads with Blind Voting logic
    public function index() {
        $adModel = new Ad();
        $voteModel = new Vote(); 
        
        $allAds = $adModel->findAll();

        // TEAM: Architect logic to check if user has already voted for each ad
        foreach ($allAds as $ad) {
            $ad->vote_count = $voteModel->getCount($ad->id);
            $ad->has_voted = Session::isLoggedIn() ? $voteModel->hasVoted($ad->id, Auth::id()) : false;
        }

        $this->view('ads/gallery', [
            'title' => 'Ad-Attack | The Gallery',
            'ads'   => $allAds
        ]);
    }

    // THE JUDGING ROOM: Shows one ad, its comments, and its vote status
    public function show($id) {
        $adModel = new Ad();
        $commentModel = new Comment();
        $voteModel = new Vote();

        $ad = $adModel->find($id);
        if (!$ad) { die("Cette œuvre n'existe pas !"); }
        
        // Add voting data to the specific Ad object
        $ad->vote_count = $voteModel->getCount($ad->id);
        $ad->has_voted = Session::isLoggedIn() ? $voteModel->hasVoted($ad->id, Auth::id()) : false;

        $comments = $commentModel->getByAd($id);

        $this->view('ads/show', [
            'title'    => 'Judging: ' . $ad->slogan,
            'ad'       => $ad,
            'comments' => $comments 
        ]);
    }

    // Affiche le formulaire
    public function submit($brief_id = 1) {
        $this->view('ads/submit', [
            'title'    => 'Submit your Ad',
            'brief_id' => $brief_id
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_FILES['ad_image'];
            $targetDir = "assets/uploads/";
            $fileName = time() . "_" . basename($image["name"]);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($image["tmp_name"], "../public/" . $targetFilePath)) {
                $adModel = new Ad();
                $agency_id = Session::get('user_id') ?? 1;

                $adModel->createAd([
                    'brief_id'   => $_POST['brief_id'] ?? 1,
                    'agency_id'  => $agency_id,
                    'slogan'     => $_POST['slogan'],
                    'image_path' => $targetFilePath
                ]);

                Session::flash('success', 'L\'attaque est lancée ! 🚀');
                header("Location: " . BASE_URL . "/ad/index");
                exit();
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        }
    }

    public function comment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $commentModel = new Comment();
            $ad_id = $_POST['ad_id'];
            $agency_id = Session::get('user_id') ?? 1;
            $commentModel->add($ad_id, $agency_id, $_POST['content']);

            Session::flash('success', 'Avis ajouté au Livre d\'Or ! 📌');
            header("Location: " . BASE_URL . "/ad/show/" . $ad_id);
            exit();
        }
    }
}