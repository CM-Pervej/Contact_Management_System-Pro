<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactPhone extends Model {
        protected $table = 'contact_phones';

        public function create($contact_id, $label, $phone){
            $label      = $this->clean($label);
            $phone      = $this->clean($phone);
            $contact_id = $this->clean($contact_id);

            $query = "INSERT INTO {$this->table} (contact_id, label, phone) VALUES ('$contact_id', '$label', '$phone')";
            $this->executeQuery($query);
            
            return $this->lastInsertedId();
        }

        public function getByContactId($contact_id) {
            $contact_id = (int)$contact_id;
            $query = "SELECT * FROM {$this->table} WHERE contact_id = '$contact_id'";
            $result = $this->selectQuery($query);

            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }

        // Delete a specific phone row (ownership-safe)
        public function delete($id, $contact_id){
            $id         = (int)$id;
            $contact_id = (int)$contact_id;
            $query      = "DELETE FROM {$this->table} WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }

        // Update a specific phone row (partial-safe)
        public function update($id, $contact_id, $label, $phone){
            $id         = (int)$id;
            $contact_id = (int)$contact_id;

            $fields = [];
            if ($label !== null) {
                $fields[] = "label='" . $this->clean($label) . "'";
            }
            if ($phone !== null) {
                $fields[] = "phone='" . $this->clean($phone) . "'";
            }

            if (empty($fields)) return false;

            $query = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }
    }
?>