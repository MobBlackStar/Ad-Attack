<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Brief;

class BriefController extends Controller {

    // TEAM: Moataz here. This is the "Lobby" method the Router was complaining about!
    // This room shows the list of all challenges.
    public function index() {
        $model = new Brief();
    
        // We use the "findAll" tool that Fedi built into the Grandparent Model.
        $allBriefs = $model->findAll();
    
        // We hand the data to the Artist (the View)
        $this->view('briefs/index', [
            'title'  => 'Ad-Attack | Briefing Room',
            'briefs' => $allBriefs 
        ]);
    }

    // TEAM: This shows the form to create a new challenge.
    public function create() {
        // Uncomment this when Donyes finishes Login!
        /*
        if (!Session::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        */
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    // TEAM: This is the logic to save the brief.
    public function store() {
        
        // 1. SECURITY CHECK: Verify CSRF Token (The Secret Handshake)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid CSRF Token. Are you a robot?");
        }

        $model = new Brief();
        // Go up 2 levels to get to 'public'
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            $data = [
                'agency_id'   => 1, // Fake ID until Login is ready
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ];

            try {
                if ($model->saveBrief($data)) {
                    Session::flash('success', 'Challenge Launched!');
                    // Use BASE_URL for safe redirect
                    header('Location: ' . BASE_URL . '/brief'); 
                    exit();
                }
            } catch (\Exception $e) {
                die("DB Error: " . $e->getMessage());
            }
        } else {
            die("Upload failed to: " . $destination);
        }
    }
    // Fedi: This shows ONE specific brief when you click "View"
    // The Router passes the ID automatically (e.g., /brief/show/5 -> $id = 5)
    public function show($id) {
        $model = new Brief();
        $brief = $model->find($id); // This uses the Grandparent Model's find()

        if (!$brief) {
            die("Error: Brief not found.");
        }

        // Load the specific view for a single brief
        $this->view('briefs/show', [
            'title' => $brief->title,
            'brief' => $brief
        ]);
    }
}