<?php
namespace App\Models;

use App\Core\Model;

// CHABEB : Ici Ritej ! J'ai créé notre premier travailleur spécialisé.
// Ce fichier s'occupe uniquement de l'armoire "agencies" (nos utilisateurs)
class Agency extends Model {
    
    // On dit à ce travailleur de travailler sur l'armoire 'agencies'
    protected $table = 'agencies';

    // RITEJ : Cette fonction prend les infos d'une nouvelle agence et les enregistre.
    public function register($name, $email, $password) {
        
        // SÉCURITÉ : On transforme le mot de passe en code secret (hachage)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    // RITEJ : J'apprends au magasinier comment chercher une agence grâce à son email.
    // Cette fonction est indispensable pour la connexion (login).
    public function findByEmail($email) {
        
        // 1. On prépare l'ordre pour la base de données : "Cherche dans mon armoire (table) l'email exact"
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        
        // 2. On exécute la recherche avec l'email donné
        $stmt->execute(['email' => $email]);
        
        // 3. On ramène le dossier (fetch). S'il n'existe pas, ça renverra 'false'.
        return $stmt->fetch(); 
    }
}