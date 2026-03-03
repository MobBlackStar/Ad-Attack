<?php
namespace App\Models;
use App\Core\Model;

// TEAM: Donyes's Worker for the 'agencies' table.
// I've trained this worker to handle all our Agency paperwork
class Agency extends Model {
    
    protected $table = 'agencies';

    // RITEJ: Saves a new agency with a hashed password
    public function register($name, $email, $password) {
        // SECURITY: Hashing the password 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    // RITEJ: The Detective. Searches the warehouse for a specific email.
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(); 
    }

    // RITEJ: The Eraser. Updates the name on the agency folder.
    // TEAM: Use this for the "Modification du Profil" requirement
    public function updateName($id, $newName) {
        $sql = "UPDATE {$this->table} SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $newName,
            'id' => $id
        ]);
    }

    // ---------------------------------------------------------
    // FEDI'S MARTIAL PEAK ENGINE (Architect's Gamification)
    // ---------------------------------------------------------
    public function getCultivationRank($agency_id) {
        $sql = "SELECT COUNT(v.id) as qi 
                FROM votes v 
                JOIN ads a ON v.ad_id = a.id 
                WHERE a.agency_id = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $agency_id]);
        $qi = $stmt->fetch()->qi ?? 0;

        if ($qi >= 100) return['rank' => '🌌 Open Heaven Rank 9', 'color' => 'badge bg-warning text-dark border border-white'];
        if ($qi >= 50)  return['rank' => '👑 Emperor Realm',       'color' => 'badge bg-danger'];
        if ($qi >= 30)  return['rank' => '⚔️ Dao Source',          'color' => 'badge bg-info text-dark'];
        if ($qi >= 15)  return['rank' => '🛡️ Saint Realm',         'color' => 'badge bg-primary'];
        if ($qi >= 5)   return ['rank' => '⚡ Immortal Ascension',  'color' => 'badge bg-success'];
        
        return ['rank' => '🧱 Tempered Body', 'color' => 'badge bg-secondary'];
    }
}