<?php
namespace App\Models;
use App\Core\Model;

// TEAM: This is the Ballot Box manager.
// It ensures nobody stuffs the ballot box (One person = One vote).
class Vote extends Model {
    protected $table = 'votes';

    // 1. Cast a Vote
    public function cast($ad_id, $user_id) {
        // "INSERT IGNORE" is a SQL trick. 
        // If this user already voted for this ad, the database just ignores the request.
        // No crash, no duplicate votes.
        $sql = "INSERT IGNORE INTO votes (ad_id, agency_id) VALUES (:ad, :user)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
    }

    // 2. Count the votes for an Ad (To show the score)
    public function getCount($ad_id) {
        $sql = "SELECT COUNT(*) as total FROM votes WHERE ad_id = :ad";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad' => $ad_id]);
        return $stmt->fetch()->total;
    }
}