<?php
namespace App\Models;

// TEAM: I created this folder because Git ignores empty folders! 
// Moataz: This file is the "Warehouse Worker" for our challenges.
use App\Core\Model;

class Brief extends Model {
    
    // Tell the worker which filing cabinet to use
    protected $table = 'briefs';

    // TEAM: This function takes the "Work Order" and saves it to the database.
    public function saveBrief($data) {
        $sql = "INSERT INTO briefs (agency_id, title, description, category, image, deadline) 
                VALUES (:agency_id, :title, :description, :category, :image, :deadline)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}