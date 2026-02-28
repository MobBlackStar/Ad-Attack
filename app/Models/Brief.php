<?php
namespace App\Models;

use App\Core\Model;

// TEAM: Moataz here. This is our Warehouse Worker for challenges.
// I've added functions to Edit, Delete, and Filter our data.
class Brief extends Model {
    
    protected $table = 'briefs';

    // TEAM: Save a brand new challenge
    public function saveBrief($data) {
        $sql = "INSERT INTO briefs (agency_id, title, description, category, image, deadline) 
                VALUES (:agency_id, :title, :description, :category, :image, :deadline)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // TEAM: The Shredder - Delete a challenge from the cabinet
    public function deleteBrief($id) {
        $stmt = $this->db->prepare("DELETE FROM briefs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // TEAM: The Update Logic - Modify an existing challenge
    public function updateBrief($id, $data) {
        $sql = "UPDATE briefs SET title = :title, description = :description, 
                category = :category, deadline = :deadline WHERE id = :id";
        
        $data['id'] = $id; // Add the ID to our data package
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // TEAM: The Filter - Grabs only the challenges from a specific category
    public function findByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM briefs WHERE category = :cat ORDER BY id DESC");
        $stmt->execute(['cat' => $category]);
        return $stmt->fetchAll();
    }
}