<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;

// TEAM: Fedi here. This is the Master of Ceremony for the Hall of Fame.
class RankingsController extends Controller {
    
    public function index() {
        $model = new Agency();
        
        // Grab the top agencies using the Architect's SQL logic
        $leaders = $model->getLeaderboard();

        $this->view('rankings/index',[
            'title' => 'Ad-Attack | Hall of Fame',
            'leaders' => $leaders
        ]);
    }
}