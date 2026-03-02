<?php
namespace App\Models;
use App\Core\Model;

// TEAM: Donyes's Worker for the 'agencies' table.
class Agency extends Model {
    
    protected $table = 'agencies';

    public function register($name, $email, $password) {
        // SECURITY: Hashing the password (15% Grade Requirement)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(); 
    }

    // THE MARTIAL PEAK ENGINE (Architect's Gamification)
    
    public function getCultivationRank($agency_id) {
        // 1. Calculate the total "Qi" (Votes received on all ads)
        $sql = "SELECT COUNT(v.id) as qi 
                FROM votes v 
                JOIN ads a ON v.ad_id = a.id 
                WHERE a.agency_id = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $agency_id]);
        $qi = $stmt->fetch()->qi ?? 0;

        // 2. Determine the Realm based on Qi
        if ($qi >= 100) return ['rank' => '🌌 Open Heaven', 'color' => 'badge bg-warning text-dark border border-white']; // God Tier
        if ($qi >= 50)  return ['rank' => '👑 Emperor Realm',       'color' => 'badge bg-danger'];  // High Tier
        if ($qi >= 30)  return ['rank' => '⚔️ Dao Source',          'color' => 'badge bg-info text-dark'];
        if ($qi >= 15)  return ['rank' => '🛡️ Saint Realm',         'color' => 'badge bg-primary'];
        if ($qi >= 5)   return ['rank' => '⚡ Immortal Ascension',  'color' => 'badge bg-success'];
        
        return ['rank' => '🧱 Tempered Body', 'color' => 'badge bg-secondary']; // The beginning
    }
}