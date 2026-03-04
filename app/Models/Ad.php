<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra : Mon ouvrier spécialisé pour les publicités (Ads).
class Ad extends Model {
    
    protected $table = 'ads';

    // TEAM : On sauvegarde la pub et le nom de l'image dans la DB
    public function createAd($data) {
        $sql = "INSERT INTO ads (brief_id, agency_id, slogan, image_path) 
                VALUES (:brief_id, :agency_id, :slogan, :image_path)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // ARCHITECT FIX: Joins with agencies so we can see the REAL name of the creator!
    public function find($id) {
        $sql = "SELECT ads.*, agencies.name as agency_name 
                FROM ads 
                JOIN agencies ON ads.agency_id = agencies.id 
                WHERE ads.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // TEAM: Fedi added Sorting for the Ads inside a Brief!
    public function getByBriefWithAgency($brief_id, $sort = 'newest') {
        $sql = "SELECT ads.*, agencies.name as agency_name,
                (SELECT COUNT(*) FROM votes WHERE votes.ad_id = ads.id) as vote_total
                FROM ads 
                JOIN agencies ON ads.agency_id = agencies.id 
                WHERE ads.brief_id = :id ";
        
        if ($sort === 'trending') {
            $sql .= " ORDER BY vote_total DESC, ads.created_at DESC";
        } else {
            $sql .= " ORDER BY ads.created_at DESC";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $brief_id]);
        return $stmt->fetchAll();
    }

    public function getByBrief($brief_id) {
        $sql = "SELECT * FROM ads WHERE brief_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $brief_id]);
        return $stmt->fetchAll();
    }
    
    // TEAM: Sarra - Let the artist fix their typos!
    public function updateSlogan($id, $slogan) {
        $sql = "UPDATE ads SET slogan = :slogan WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['slogan' => $slogan, 'id' => $id]);
    }

    // TEAM: Fedi - Added a JOIN so the Main Gallery shows REAL names, not "Unknown".
    public function getAllWithAgency() {
        $sql = "SELECT ads.*, agencies.name as agency_name 
                FROM ads 
                LEFT JOIN agencies ON ads.agency_id = agencies.id 
                ORDER BY ads.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }
}