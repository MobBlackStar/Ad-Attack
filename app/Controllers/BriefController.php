<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Brief;
// TEAM: We are bringing in the Security Guard!
use App\Core\Auth;

class BriefController extends Controller {

    // THE LOBBY: Shows all the challenges on the wall.
    public function index() {
        $model = new Brief();
        $allBriefs = $model->findAll();
    
        $this->view('briefs/index', [
            'title'  => 'Ad-Attack | Briefing Room',
            'briefs' => $allBriefs 
        ]);
    }

    // THE FORM: Shows the "Create" page.
    public function create() {
        // TEAM: The Bouncer is here! If you don't have a badge, you get kicked out.
        // Donyes's login system is now active.
        Auth::requireLogin(); 
        
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    // THE LOGIC: Saves the brief to the database.
    public function store() {
        
        // 1. SECURITY: The Secret Handshake (CSRF)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Nice try, hacker. Go home.");
        }

        $model = new Brief();
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";

        // Create the folder if it doesn't exist (Architect's magic)
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            $model->saveBrief([
                // TEAM: "Agency #1" has been fired. 
                // We now grab the REAL ID from the user's badge!
                'agency_id'   => Auth::id(), 
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ]);

            Session::flash('message', 'Brief Published! Let the games begin. 📢');
            header('Location: ' . BASE_URL . '/brief');
            exit();
        } else {
            die("Upload failed. The Loading Dock is closed.");
        }
    }

    // THE DETAIL PAGE: Shows one brief.
    public function show($id) {
        $model = new Brief();
        $brief = $model->find($id);
        if (!$brief) { die("404: This brief has vanished into the void."); }

        // TEAM: Architect magic to connect Sarra's ads to Moataz's brief
        $adModel = new \App\Models\Ad();
        $ads = $adModel->getByBrief($id);

        $this->view('briefs/show', [
            'title' => $brief->title,
            'brief' => $brief,
            'ads'   => $ads
        ]);
    }
}