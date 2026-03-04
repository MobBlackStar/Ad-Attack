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
        Auth::requireLogin();
        $model = new Ad();
        $ad = $model->find($id);

        if ($ad && ($ad->agency_id == Auth::id() || Auth::id() == 1)) {
            $model->delete($id);
            Session::flash('message', 'Masterpiece removed from gallery.');
        }
        header('Location: ' . BASE_URL . '/index.php?url=ad/index');
        exit();
    }

    // THE EXHIBITION: Shows all ads with Blind Voting logic
    public function index() {
        $adModel = new Ad();
        $voteModel = new \App\Models\Vote(); 
        
        // ARCHITECT FIX: Use the new method to grab names!
        $allAds = $adModel->getAllWithAgency();

        foreach ($allAds as $ad) {
            $ad->vote_count = $voteModel->getCount($ad->id);
            $ad->has_voted = Session::isLoggedIn() ? $voteModel->hasVoted($ad->id, Auth::id()) : false;
        }

        $this->view('ads/gallery',[
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
                header("Location: " . BASE_URL . "/index.php?url=ad/index");
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
            header("Location: " . BASE_URL . "/index.php?url=ad/show/" . $ad_id);
            exit();
        }
    }

    // ==========================================================
    // 🎭 SARRA: VOICI LA FONCTION MANQUANTE POUR L'AJAX !
    // ==========================================================
    public function vote($ad_id) {
        // On dit au navigateur qu'on va lui répondre en langage "Robot" (JSON)
        header('Content-Type: application/json');

        if (!Session::isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Connecte-toi pour voter !']);
            exit();
        }

        $voteModel = new Vote();
        $user_id = Auth::id();

        // On utilise la méthode 'cast' de Fedi
        $result = $voteModel->cast($ad_id, $user_id);

        if ($result) {
            // On récupère le nouveau score
            $newScore = $voteModel->getCount($ad_id);
            echo json_encode(['success' => true, 'new_score' => $newScore]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tu as déjà voté !']);
        }
        exit();
    }

    // TEAM: Sarra - Show the Edit Room
    public function edit($id) {
        \App\Core\Auth::requireLogin();
        $model = new Ad();
        $ad = $model->find($id);

        // Security: Only the owner or Overlord can edit
        if (!$ad || ($ad->agency_id != \App\Core\Auth::id() && \App\Core\Auth::id() != 1)) {
            die("Security Error: You cannot paint over someone else's work.");
        }

        $this->view('ads/edit',[
            'title' => 'Edit Masterpiece',
            'ad' => $ad
        ]);
    }

    // TEAM: Sarra - Save the new slogan
    public function update($id) {
        \App\Core\Auth::requireLogin();
        if (!\App\Core\Session::checkCSRF($_POST['csrf_token'] ?? '')) die("CSRF Error");

        $model = new Ad();
        $model->updateSlogan($id, $_POST['slogan']);

        \App\Core\Session::flash('message', 'Campaign Slogan Updated! ✍️');
        header('Location: ' . BASE_URL . '/ad/show/' . $id);
        exit();
    }
}