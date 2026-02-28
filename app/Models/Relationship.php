<?php
    namespace App\Models;
    use App\Core\Model;

    class Relationship extends Model {
        protected $table = 'relationships';

        // Create a new relation
        public function create($rel_name) {
            $rel_name = $this->clean($rel_name);
            $query = "INSERT INTO {$this->table} (rel_name) VALUES ('$rel_name')";
            $this->executeQuery($query);
            return $this->lastInsertedId();
        }

        // Get all relations
        public function getAll() {
            $query = "SELECT * FROM {$this->table} ORDER BY id ASC";
            $result = $this->selectQuery($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Get relation by ID
        public function getById($id) {
            $id = (int) $id;
            $query = "SELECT * FROM {$this->table} WHERE id = $id";
            $result = $this->selectQuery($query);
            return $result->fetch_assoc();
        }

        // Get relation by name (to prevent duplicates)
        public function getByRel($rel_name) {
            $rel_name = $this->clean($rel_name);
            $query = "SELECT * FROM {$this->table} WHERE LOWER(rel_name) = LOWER('$rel_name') LIMIT 1";
            $result = $this->selectQuery($query);
            return $result->fetch_assoc();
        }

        // Update an existing relation
        public function updateRelation($id, $rel_name) {
            $id = (int)$id;
            $rel_name = $this->clean($rel_name);
            $query = "UPDATE {$this->table} SET rel_name = '$rel_name' WHERE id = $id";
            return $this->executeQuery($query);
        }
        
        // ✅ Delete a relation by ID
        public function deleteRelation($id) {
            $id = (int)$id;
            $query = "DELETE FROM {$this->table} WHERE id = $id";
            return $this->executeQuery($query);
        }
    }
?>