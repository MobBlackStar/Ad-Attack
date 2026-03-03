<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Agency;

// TEAM: I'm the Lobby Manager. I show the current state of the world!
class HomeController extends Controller {
    
    public function index() {
        $agencyModel = new Agency();
        // Fedi: Fetching the top 3 for the homepage display
        $hallOfFame = $agencyModel->getLeaderboard();

        $this->view('home', [
            'title' => 'Ad-Attack | The Arena',
            'topAgencies' => $hallOfFame
        ]);
    }
}