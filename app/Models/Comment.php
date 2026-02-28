<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra: This is my archivist for the feedback box. 
// He only knows how to write to the database and read from it.
class Comment extends Model {
    protected $table = 'comments';

    // Just save the text, don't ask questions!
    public function add($ad_id, $agency_id, $content) {
        $sql = "INSERT INTO comments (ad_id, agency_id, content) VALUES (:ad, :agency, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ad'      => $ad_id,
            'agency'  => $agency_id,
            'content' => $content
        ]);
    }

    // Get all comments for a specific masterpiece
    public function getByAd($ad_id) {
        $sql = "SELECT comments.*, agencies.name as author 
                FROM comments 
                JOIN agencies ON comments.agency_id = agencies.id 
                WHERE ad_id = :id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $ad_id]);
        return $stmt->fetchAll();
    }
}