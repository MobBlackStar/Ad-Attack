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
}