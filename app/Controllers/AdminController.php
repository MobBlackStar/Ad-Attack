<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
// TEAM: We are bringing in EVERY worker because the Admin sees everything.
use App\Models\Agency;
use App\Models\Brief;
use App\Models\Ad;

class AdminController extends Controller {

    public function __construct() {
        // TEAM: This is the "Bouncer" for the Admin room.
        // Even if someone types /admin in the URL, they get blocked unless 
        // they are User #1 (The Architect). 
        Auth::requireLogin();
        if (Auth::id() != 1) {
            die("<h1 style='color:red; text-align:center;'>🛑 ACCESS DENIED: Only the Overlord enters here.</h1>");
        }
    }

    // TEAM: This is the "Monitor Room". We pull all files from all cabinets.
    public function index() {
        $agencyModel = new Agency();
        $briefModel = new Brief();
        $adModel = new Ad();

        // Architect: We are grabbing the entire history of the project here.
        $this->view('admin/dashboard', [
            'title'    => 'God Mode | Control Panel',
            'agencies' => $agencyModel->findAll(),
            'briefs'   => $briefModel->findAll(),
            'ads'      => $adModel->findAll()
        ]);
    }

    // TEAM: The "Eject Button". 
    // If an agency is toxic, User #1 can delete them instantly.
    public function banUser($id) {
        if ($id == 1) die("Error: You cannot ban the Architect!");

        $model = new Agency();
        // This uses the Grandparent Model's 'delete' power!
        $model->delete($id); 

        Session::flash('message', 'Agency banished to the shadow realm. 💀');
        header('Location: ' . BASE_URL . '/admin');
        exit();
    }
}