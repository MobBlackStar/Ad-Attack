<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra : My specialist worker for the ads.
class Ad extends Model {
    protected $table = 'ads';

    public function createAd($data) {
        $sql = "INSERT INTO ads (brief_id, agency_id, slogan, image_path) 
                VALUES (:brief_id, :agency_id, :slogan, :image_path)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}