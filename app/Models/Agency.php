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

}