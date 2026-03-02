<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\Models\Vote;

// TEAM: This Controller is special. It does NOT show HTML pages.
// It speaks "JSON" (Machine Language) to our Javascript file.
class VoteController extends Controller {

    // The Javascript sends a signal here when someone clicks "Vote"
    public function cast() {
        
        // 1. Security: Only logged-in agencies can vote
        if (!Session::isLoggedIn()) {
            echo json_encode(['status' => 'error', 'message' => 'You must be logged in to vote!']);
            exit;
        }

        // 2. Read the secret whisper from Javascript (JSON input)
        $input = json_decode(file_get_contents('php://input'), true);
        $ad_id = $input['ad_id'] ?? 0;

        if (!$ad_id) {
            echo json_encode(['status' => 'error', 'message' => 'Error: Ad not found.']);
            exit;
        }

        // 3. Drop the ballot in the box
        $voteModel = new Vote();
        $voteModel->cast($ad_id, Auth::id());

        // 4. Recount the votes immediately
        $newCount = $voteModel->getCount($ad_id);

        // 5. Whisper back the new score to the browser
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success', 
            'new_score' => $newCount,
            'message' => 'Vote Registered!'
        ]);
        exit;
    }
}