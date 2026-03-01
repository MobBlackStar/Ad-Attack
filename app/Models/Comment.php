<?php
namespace App\Models;
use App\Core\Model;

// TEAM - Sarra : C'est mon archiviste pour les commentaires.
// Fedi: J'ai nettoyé ce fichier pour qu'il respecte le MVC (Aucun $_POST ici !)
class Comment extends Model {
    
    protected $table = 'comments';

    // TEAM : On enregistre un commentaire pour une pub précise
    public function add($ad_id, $agency_id, $content) {
        $sql = "INSERT INTO comments (ad_id, agency_id, content) VALUES (:ad, :agency, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ad'      => $ad_id,
            'agency'  => $agency_id,
            'content' => $content
        ]);
    }

    // TEAM : On récupère tous les avis d'une pub spécifique (avec le nom de l'agence)
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