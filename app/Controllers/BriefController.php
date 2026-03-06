<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Auth;
use App\Models\Brief;
use App\Models\Ad; 

class BriefController extends Controller {

    // TEAM: The Lobby. Now handles Search, Filter, Sort, AND Pagination!
    public function index() {
        $model = new Brief();
        
        $category = $_GET['cat'] ?? 'All'; 
        $sort = $_GET['sort'] ?? 'newest'; 
        $search = $_GET['search'] ?? '';   

        // --- PAGINATION MATH ---
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 6; // Show 6 Briefs per page
        $offset = ($page - 1) * $limit;

        // Fedi: Ask the warehouse for the total count so we can draw the page buttons
        $totalBriefs = $model->getTotalFiltered($category, $search);
        $totalPages = ceil($totalBriefs / $limit);

        // Fedi: Grab the exact 6 briefs for this specific page
        $briefs = $model->getFilteredBriefs($category, $sort, $search, $limit, $offset);
    
        $this->view('briefs/index',[
            'title'           => 'Ad-Attack | Briefing Room',
            'briefs'          => $briefs,
            'currentCategory' => $category,
            'currentSort'     => $sort,
            'currentSearch'   => $search,
            'currentPage'     => $page,
            'totalPages'      => $totalPages
        ]);
    }

    public function create() {
        Auth::requireLogin(); 
        $this->view('briefs/create',['title' => 'Ad-Attack | New Brief']);
    }

    public function store() {
        Auth::requireLogin();
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $model = new Brief();
        $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            $model->saveBrief([
                'agency_id'   => Auth::id(), 
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ]);

            Session::flash('message', 'Challenge Launched! Let the attacks begin! 🚀');
            header('Location: ' . BASE_URL . '/brief'); 
            exit();
        } else {
            die("Upload failed.");
        }
    }

    public function show($id) {
        $model = new Brief();
        $brief = $model->find($id);
        if (!$brief) { die("This brief has been shredded or never existed."); }

        $adModel = new Ad(); 
        $voteModel = new \App\Models\Vote();
        
        // Catch the sort method from the URL
        $sort = $_GET['sort'] ?? 'newest';
        $ads = $adModel->getByBriefWithAgency($id, $sort);

        foreach ($ads as $ad) {
            $ad->vote_count = $voteModel->getCount($ad->id);
            $ad->has_voted = Session::isLoggedIn() ? $voteModel->hasVoted($ad->id, Auth::id()) : false;
        }

        $this->view('briefs/show',[
            'title' => $brief->title,
            'brief' => $brief,
            'ads'   => $ads,
            'currentSort' => $sort // Pass this to the view!
        ]);
    }

    public function delete($id) {
        Auth::requireLogin();
        $model = new Brief();
        $brief = $model->find($id);

        if ($brief && ($brief->agency_id == Auth::id() || Auth::id() == 1)) {
            $model->delete($id);
            Session::flash('message', 'Challenge shredded and deleted! 🗑️');
        } else {
            Session::flash('message', 'Access Denied: You cannot destroy someone else\'s work.');
        }
        header('Location: ' . BASE_URL . '/brief');
        exit();
    }

    public function edit($id) {
        Auth::requireLogin();
        $model = new Brief();
        $brief = $model->find($id);

        if (!$brief || ($brief->agency_id != Auth::id() && Auth::id() != 1)) {
            die("Error: You do not have permission to edit this blueprint.");
        }

        $this->view('briefs/edit',[
            'title' => 'Edit Brief: ' . $brief->title,
            'brief' => $brief
        ]);
    }

    public function update($id) {
        Auth::requireLogin();
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("CSRF Error");

        $model = new Brief();
        $brief = $model->find($id);
        if (!$brief || ($brief->agency_id != Auth::id() && Auth::id() != 1)) {
            die("Error: You do not have permission to edit this blueprint.");
        }

        $data = [
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'category'    => $_POST['category'],
            'deadline'    => $_POST['deadline'],
            'image'       => !empty($brief->image) ? basename($brief->image) : ''
        ];

        // Optional new image upload (fix broken or replace)
        if (!empty($_FILES['brief_image']['name']) && $_FILES['brief_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 2) . "/public/assets/uploads/";
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
            $imageName = time() . '_' . $_FILES['brief_image']['name'];
            $destination = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
                $data['image'] = $imageName;
            }
        }

        if ($model->updateBrief($id, $data)) {
            Session::flash('message', 'Brief blueprint updated successfully! 💾');
            header('Location: ' . BASE_URL . '/brief');
            exit();
        }
    }
}