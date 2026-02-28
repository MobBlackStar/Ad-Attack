<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Brief;

class BriefController extends Controller {

    // TEAM: Moataz here. This is the "Lobby" method the Router was complaining about!
    // This room shows the list of all challenges.
    // TEAM: Moataz here. I'm updating the Lobby to show REAL data from the DB!
    public function index() {
        $model = new Brief();
    
        // We use the "findAll" tool that Fedi built into the Grandparent Model.
        // This grabs every challenge from the 'briefs' table.
        $allBriefs = $model->findAll();
    
        // We hand the data to the Artist (the View)
        $this->view('briefs/index', [
            'title'  => 'Ad-Attack | Briefing Room',
            'briefs' => $allBriefs // Passing the array of challenges
        ]);
    }

    // TEAM: This shows the form to create a new challenge.
    public function create() {
        if (!Session::isLoggedIn()) {
            header('Location: /Ad-Attack/public/index.php?url=home');
            exit();
        }
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    // TEAM: This is the logic we just fixed.
    public function store() {
        $model = new Brief();
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the folder if it's missing
        }

        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            $data = [
                'agency_id'   => 1, // Fake ID for testing
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ];

            try {
                if ($model->saveBrief($data)) {
                    Session::flash('success', 'Challenge Launched!');
                    // This is where the redirect happened!
                    header('Location: /Ad-Attack/public/index.php?url=brief/index');
                    exit();
                }
            } catch (\Exception $e) {
                die("DB Error: " . $e->getMessage());
            }
        } else {
            die("Upload failed to: " . $destination);
        }
    }
}