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

    public function getByBrief($brief_id) {
        $sql = "SELECT * FROM ads WHERE brief_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $brief_id]);
        return $stmt->fetchAll();
    }
}