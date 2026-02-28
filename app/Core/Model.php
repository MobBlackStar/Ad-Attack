<?php
namespace App\Core;

use PDO;

// TEAM : C'est la base de tous nos modèles.
abstract class Model {
    protected $db;
    protected $table; 

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // TEAM : Récupère tout.
    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    // TEAM - Sarra : VERIFIE BIEN QUE CETTE FONCTION EST ICI !
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}