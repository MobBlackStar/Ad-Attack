<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra : This is the specialist worker for our Ads.
class Ad extends Model {
    
    protected $table = 'ads';

    // TEAM: This function saves the creative attack to the database.
    public function createAd($data) {
        $sql = "INSERT INTO ads (brief_id, agency_id, slogan, image_path) 
                VALUES (:brief_id, :agency_id, :slogan, :image_path)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // ARCHITECT FIX: This is the missing instruction the Controller was begging for
    // It filters the ads so we only show the ones belonging to a specific brief.
    public function getByBrief($brief_id) {
        $sql = "SELECT * FROM ads WHERE brief_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $brief_id]);
        return $stmt->fetchAll();
    }
}