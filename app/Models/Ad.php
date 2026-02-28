<?php
namespace App\Models;

use App\Core\Model;

// TEAM - Sarra : Mon ouvrier spécialisé pour les publicités.
class Ad extends Model {
    
    protected $table = 'ads';

    // TEAM : Voici la technique que le contrôleur essaie d'appeler !
    public function createAd($data) {
        $sql = "INSERT INTO ads (brief_id, agency_id, slogan, image_path) 
                VALUES (:brief_id, :agency_id, :slogan, :image_path)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}