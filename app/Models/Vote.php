<?php
namespace App\Models;
use App\Core\Model;

// TEAM: Fedi here. This is the worker managing the "Ballot Box" (votes table).
class Vote extends Model {
    protected $table = 'votes';

    // 1. Cast a Vote (Drop ballot in box)
    public function cast($ad_id, $user_id) {
        $sql = "INSERT IGNORE INTO votes (ad_id, agency_id) VALUES (:ad, :user)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
    }

    // 2. Remove a Vote (Take ballot out) - NEW FEATURE
    public function remove($ad_id, $user_id) {
        $sql = "DELETE FROM votes WHERE ad_id = :ad AND agency_id = :user";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
    }

    // 3. Count the votes for an Ad
    public function getCount($ad_id) {
        $sql = "SELECT COUNT(*) as total FROM votes WHERE ad_id = :ad";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad' => $ad_id]);
        return $stmt->fetch()->total ?? 0;
    }

    // 4. Check if specific user voted
    public function hasVoted($ad_id, $user_id) {
        $sql = "SELECT id FROM votes WHERE ad_id = :ad AND agency_id = :user LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad' => $ad_id, 'user' => $user_id]);
        return $stmt->fetch() ? true : false;
    }
}