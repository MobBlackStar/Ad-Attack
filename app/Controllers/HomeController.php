<?php
namespace App\Controllers;
//na3ytou lel Big Boy controller lahne
use App\Core\Controller;

// TEAM: This is an example of a Controller (A Manager). 
// The Router wakes this file up when someone visits our main URL.
class HomeController extends Controller {
    
    public function index() {
        // We tell the Big Boy Controller to load 'home.php' and we hand it a title.
        $this->view('home',[
            'title' => 'Ad-Attack | The Arena'
        ]);
    }
}