<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Auth;
use App\Models\Brief;
use App\Models\Ad; // Fedi: Added this so the 'show' method knows what an Ad is!

class BriefController extends Controller {

    // TEAM: Moataz here. This is the "Lobby". 
    // Fedi here, uh we had a bug and its fixed now
    public function index() {
        $model = new Brief();
        $sort = $_GET['sort'] ?? 'newest'; // TEAM: Default to newest

        if ($sort == 'trending') {
            $briefs = $model->findAllTrending();
        } else {
            $briefs = $model->findAll(); // Assuming findAll sorts by date desc
        }
    
        $this->view('briefs/index', [
            'title'  => 'Briefing Room',
            'briefs' => $briefs,
            'currentSort' => $sort
        ]);
    }

    public function create() {
        // Donyes: The bouncer is active! You need a badge to post.
        Auth::requireLogin(); 
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    public function store() {
        Auth::requireLogin();
        
        // SECURITY: Fedi's Secret Handshake (CSRF)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake. Go back to the shadow realm.");
        }

        $model = new Brief();
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            $model->saveBrief([
                'agency_id'   => Auth::id(), // TEAM: Using real ID now! No more Agency #1.
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ]);

            Session::flash('message', 'Challenge Launched! Let the attacks begin! 🚀');
            header('Location: ' . BASE_URL . '/brief'); 
            exit();
        }
    }

    // TEAM: Moataz worked on the Detail page, Fedi linked Sarra's ads to it!
    public function show($id) {
        $model = new Brief();
        $brief = $model->find($id);
        if (!$brief) { die("This brief has been shredded or never existed."); }

        // TEAM: Architect Magic - Pulling the Ads and checking the Voting status
        $adModel = new Ad(); 
        $voteModel = new \App\Models\Vote();
        $ads = $adModel->getByBriefWithAgency($id);

        foreach ($ads as $ad) {
            $ad->vote_count = $voteModel->getCount($ad->id);
            $ad->has_voted = Session::isLoggedIn() ? $voteModel->hasVoted($ad->id, Auth::id()) : false;
        }

        $this->view('briefs/show', [
            'title' => $brief->title,
            'brief' => $brief,
            'ads'   => $ads // Fedi's glue logic
        ]);
    }

    // TEAM: Moataz's "Shredder" Action.
    public function delete($id) {
        Auth::requireLogin();
        $model = new Brief();
        $brief = $model->find($id);

        // SECURITY: Only the owner (or the Overlord Admin) can shred this!
        if ($brief && ($brief->agency_id == Auth::id() || Auth::id() == 1)) {
            $model->delete($id);
            Session::flash('message', 'Challenge shredded and deleted! 🗑️');
        } else {
            Session::flash('message', 'Access Denied: You cannot destroy someone else\'s work.');
        }
        header('Location: ' . BASE_URL . '/brief');
    }

    // TEAM: Moataz's Edit Room
    public function edit($id) {
        Auth::requireLogin();
        $model = new Brief();
        $brief = $model->find($id);

        if (!$brief || ($brief->agency_id != Auth::id() && Auth::id() != 1)) {
            die("Error: You do not have permission to edit this blueprint.");
        }

        $this->view('briefs/edit', [
            'title' => 'Edit Brief: ' . $brief->title,
            'brief' => $brief
        ]);
    }

    // TEAM: Processing the blueprint changes (The Update)
    public function update($id) {
        Auth::requireLogin();
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("CSRF Error");

        $model = new Brief();
        $data = [
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'category'    => $_POST['category'],
            'deadline'    => $_POST['deadline']
        ];

        if ($model->updateBrief($id, $data)) {
            Session::flash('message', 'Brief blueprint updated successfully! 💾');
            header('Location: ' . BASE_URL . '/brief');
            exit();
        }
    }
}