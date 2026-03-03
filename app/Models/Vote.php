<?php
namespace App\Models;
use App\Core\Model;

// TEAM: Fedi here. This is the worker managing the "Ballot Box" (votes table).
class Vote extends Model {
    protected $table = 'votes';

    // TEAM: This function drops a ballot. 
    // We use "INSERT IGNORE" so if they try to vote twice, the DB just ignores it.
    public function cast($ad_id, $user_id) {
        $sql = "INSERT IGNORE INTO votes (ad_id, agency_id) VALUES (:ad, :user)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
    }

    // TEAM: This function counts all the ballots for a specific Ad.
    public function getCount($ad_id) {
        $sql = "SELECT COUNT(*) as total FROM votes WHERE ad_id = :ad";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad' => $ad_id]);
        $result = $stmt->fetch();
        return $result->total ?? 0;
    }

    // ARCHITECT FIX: This was the missing function causing the crash!
    // It checks if a specific person has already voted.
    public function hasVoted($ad_id, $user_id) {
        $sql = "SELECT id FROM votes WHERE ad_id = :ad AND agency_id = :user LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
        return $stmt->fetch() ? true : false;
    }
}