<?php
namespace App\Models;
use App\Core\Model;

class Brief extends Model {
    protected $table = 'briefs';

    public function saveBrief($data) {
        $sql = "INSERT INTO briefs (agency_id, title, description, category, image, deadline) 
                VALUES (:agency_id, :title, :description, :category, :image, :deadline)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function updateBrief($id, $data) {
        $sql = "UPDATE briefs SET title = :title, description = :description, 
                category = :category, deadline = :deadline, image = :image WHERE id = :id";
        $data['id'] = $id;
        return $this->db->prepare($sql)->execute($data);
    }

    // TEAM: Fedi - Added LIMIT and OFFSET for Dynamic Pagination!
    public function getFilteredBriefs($category = 'All', $sort = 'newest', $keyword = '', $limit = 6, $offset = 0) {
        $sql = "SELECT b.*, COUNT(v.id) as vote_count 
                FROM briefs b 
                LEFT JOIN ads a ON b.id = a.brief_id 
                LEFT JOIN votes v ON a.id = v.ad_id";
        
        $params = [];
        $conditions =[];

        if ($category !== 'All' && !empty($category)) {
            $conditions[] = "b.category = :cat";
            $params['cat'] = $category;
        }
        if (!empty($keyword)) {
            $conditions[] = "(b.title LIKE :key OR b.description LIKE :key)";
            $params['key'] = "%$keyword%";
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " GROUP BY b.id";

        if ($sort === 'trending') {
            $sql .= " ORDER BY vote_count DESC, b.id DESC";
        } else {
            $sql .= " ORDER BY b.id DESC";
        }

        // THE PAGINATION MAGIC
        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // TEAM: Fedi - We need to count how many total items exist so we know how many pages to draw!
    public function getTotalFiltered($category = 'All', $keyword = '') {
        $sql = "SELECT COUNT(*) as total FROM briefs";
        $params =[];
        $conditions = [];

        if ($category !== 'All' && !empty($category)) {
            $conditions[] = "category = :cat";
            $params['cat'] = $category;
        }
        if (!empty($keyword)) {
            $conditions[] = "(title LIKE :key OR description LIKE :key)";
            $params['key'] = "%$keyword%";
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()->total ?? 0;
    }
}