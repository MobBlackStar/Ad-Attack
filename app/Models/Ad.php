<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra : Mon ouvrier spécialisé pour les publicités (Ads).
// Il ne fait que parler à la base de données.
class Ad extends Model {
    
    protected $table = 'ads';

    // TEAM : On sauvegarde la pub et le nom de l'image dans la DB
    public function createAd($data) {
        $sql = "INSERT INTO ads (brief_id, agency_id, slogan, image_path) 
                VALUES (:brief_id, :agency_id, :slogan, :image_path)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}