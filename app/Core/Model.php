<?php
namespace App\Core;

use PDO;

// TEAM: Every Model you make (User, Brief, Ad) MUST extend this class.
// E7seb hedha ensen 3emle9 fi warehouse. It handles the basic database lifting for you.
abstract class Model {
    protected $db;
    protected $table; // You will set this in your child classes (e.g., $table = 'briefs')

    public function __construct() {
        // Automatically grab the shared database connection
        $this->db = Database::getConnection();
    }

    // Client: You can use this free function to grab all the Briefs for the homepage!
    // No need to write the SQL manually.
    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    // salla7na el view function here

    // Get ONE item by ID (The Detail Page needs this)
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Delete an item (The "Shredder" needs this)
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}