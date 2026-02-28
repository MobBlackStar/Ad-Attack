<?php
namespace App\Models;

use App\Core\Model;

// TEAM - Sarra : C'est mon archiviste pour les commentaires.
// Il s'occupe de mettre les avis dans la bonne boîte.
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

    // TEAM : On récupère tous les avis d'une pub spécifique
    public function getByAd($ad_id) {
        $sql = "SELECT comments.*, agencies.name as author 
                FROM comments 
                JOIN agencies ON comments.agency_id = agencies.id 
                WHERE ad_id = :id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $ad_id]);
        return $stmt->fetchAll();
    }
    // TEAM - Sarra : Cette fonction s'occupe d'enregistrer le commentaire envoyé
// par le formulaire de la page "Show".
public function comment() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $ad_id = $_POST['ad_id'];
        $content = $_POST['content'];

        // TEAM - Note : Comme Donyes n'a pas fini le login, on utilise l'ID 1
        // pour l'agence qui commente.
        $agency_id = 1; 

        // On appelle le travailleur spécialisé dans les commentaires
        $commentModel = new \App\Models\Comment();
        
        // On enregistre !
        $commentModel->add($ad_id, $agency_id, $content);

        // TEAM : Un petit message de succès (Le "Flash" de Fedi)
        \App\Core\Session::flash('success', 'Ton commentaire est posté !');

        // On recharge la page pour voir le commentaire
        header("Location: index.php?url=ad/show/" . $ad_id);
    }
}
}