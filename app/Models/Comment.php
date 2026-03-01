<?php
namespace App\Models;

use App\Core\Model;

// TEAM - Sarra: This is our Archivist for feedback. 
// It handles the "Handshake" with the database to get comments.
class Comment extends Model {
    
    protected $table = 'comments';

    // Save a new feedback to the database
    public function add($ad_id, $agency_id, $content) {
        $sql = "INSERT INTO comments (ad_id, agency_id, content) VALUES (:ad, :agency, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ad'      => $ad_id,
            'agency'  => $agency_id,
            'content' => $content
        ]);
    }

    // Retrieve comments with the Author's name
    public function getByAd($ad_id) {
        $sql = "SELECT comments.*, agencies.name as author, agencies.id as agency_id
                FROM comments 
                LEFT JOIN agencies ON comments.agency_id = agencies.id 
                WHERE ad_id = :id 
                ORDER BY comments.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $ad_id]);
        $comments = $stmt->fetchAll();

        // ARCHITECT MAGIC: Measure the Cultivation Level of each commenter
        $agencyModel = new \App\Models\Agency();
        
        foreach ($comments as $comment) {
            if ($comment->agency_id) {
                // Returns the Array ['rank' => '...', 'color' => '...']
                $comment->cultivation = $agencyModel->getCultivationRank($comment->agency_id);
            } else {
                $comment->cultivation = ['rank' => '👻 Wandering Ghost', 'color' => 'badge bg-dark'];
            }
        }

        return $comments;
    }
}