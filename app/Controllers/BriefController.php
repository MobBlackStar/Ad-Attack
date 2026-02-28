<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Brief;

class BriefController extends Controller {

    // TEAM: Moataz, Changed it so The Lobby - Now supports the Category Filter!
    public function index() {
        $model = new Brief();
        
        // Check if a category was requested in the URL (e.g. /brief/index?category=Tech)
        $category = $_GET['category'] ?? 'All';

        if ($category !== 'All') {
            $allBriefs = $model->findByCategory($category);
        } else {
            $allBriefs = $model->findAll();
        }
    
        $this->view('briefs/index', [
            'title'  => 'Ad-Attack | Briefing Room',
            'briefs' => $allBriefs,
            'currentCategory' => $category
        ]);
    }

    public function create() {
        // Donyes: I'll turn this back on once your Login system is pushed to main!
        /*
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Login required to post a brief.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        */
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    public function store() {
        // Fedi: Secret Handshake Check (CSRF)
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Token.");
        }

        $model = new Brief();
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";

        // Move the physical file to the vault
        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $uploadDir . $imageName)) {
            $data = [
                'agency_id'   => 1, // Placeholder
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ];

            if ($model->saveBrief($data)) {
                Session::flash('success', 'Challenge Launched!');
                header('Location: ' . BASE_URL . '/brief'); 
                exit();
            }
        }
    }

    // TEAM: Moataz, Worked On The Shredder Action
    public function delete($id) {
        $model = new Brief();
        $brief = $model->find($id);

        // Security check: Only the owner (Agency 1) can delete
        if ($brief && $brief->agency_id == 1) {
            $model->deleteBrief($id);
            Session::flash('success', 'Challenge shredded!');
        } else {
            Session::flash('error', 'Access Denied.');
        }
        header('Location: ' . BASE_URL . '/brief');
    }

    // TEAM: Moataz, Worked On Showing the Edit Form
    public function edit($id) {
        $model = new Brief();
        $brief = $model->find($id);

        if (!$brief || $brief->agency_id != 1) {
            die("Error: You cannot edit this.");
        }

        $this->view('briefs/edit', [
            'title' => 'Edit Brief: ' . $brief->title,
            'brief' => $brief
        ]);
    }

    // TEAM: Moataz, Worked On Processing the Edit (Update the cabinet)
    public function update($id) {
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("CSRF Error");

        $model = new Brief();
        $data = [
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'category'    => $_POST['category'],
            'deadline'    => $_POST['deadline']
        ];

        if ($model->updateBrief($id, $data)) {
            Session::flash('success', 'Brief updated!');
            header('Location: ' . BASE_URL . '/brief');
            exit();
        }
    }

    public function show($id) {
        $model = new Brief();
        $brief = $model->find($id);
        if (!$brief) die("Not found.");
        $this->view('briefs/show', ['title' => $brief->title, 'brief' => $brief]);
    }
}