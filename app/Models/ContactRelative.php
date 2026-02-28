<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactRelative extends Model {
        protected $table = 'contact_relatives';

        // Add a relation
        public function create($contactId, $relativeId, $relationshipId) {
            $contactId     = (int)$contactId;
            $relativeId    = (int)$relativeId;
            $relationshipId = (int)$relationshipId;

            if ($contactId === $relativeId) {
                throw new \Exception("You cannot relate a contact to itself");
            }

            $query = "
                INSERT INTO {$this->table}
                (contact_id, relative_contact_id, relationship_id)
                VALUES ($contactId, $relativeId, $relationshipId)
            ";

            return $this->executeQuery($query);
        }

        // Get relatives of a contact
        public function getByContact($contactId) {
            $contactId = (int)$contactId;

            $query = "
                SELECT 
                    cr.id,
                    c.id AS relative_id,
                    CONCAT(c.first_name,' ',c.last_name) AS name,
                    r.rel_name,
                    r.id AS relationship_id
                FROM {$this->table} cr
                JOIN contacts c ON c.id = cr.relative_contact_id
                JOIN relationships r ON r.id = cr.relationship_id
                WHERE cr.contact_id = $contactId
                ORDER BY r.rel_name ASC
            ";

            $result = $this->selectQuery($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Delete a relation
        public function delete($id) {
            $id = (int)$id;
            return $this->executeQuery("DELETE FROM {$this->table} WHERE id = $id");
        }

        // Update an existing relation
        public function update($id, $relativeId, $relationshipId) {
            $id = (int)$id;
            $relativeId = (int)$relativeId;
            $relationshipId = (int)$relationshipId;

            $query = "
                UPDATE {$this->table} 
                SET relative_contact_id = $relativeId, relationship_id = $relationshipId 
                WHERE id = $id
            ";

            return $this->executeQuery($query);
        }
    }
?>