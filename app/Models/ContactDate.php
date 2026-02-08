<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactDate extends Model{
        protected $table = "contact_dates";

        public function create($contact_id, $label, $date) {
            $label      = $this->clean($label);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, date) VALUES ('$contact_id', '$label', '$date')";
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

        public function delete($id, $contact_id){
            $id         = (int)$id;
            $contact_id = (int)$contact_id;
            $query      = "DELETE FROM {$this->table} WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }

        public function update($id, $contact_id, $label, $date){
            $id = (int)$id;
            $contact_id = (int)$contact_id;

            $fields = [];
            if ($label !== null) {
                $fields[] = "label='" . $this->clean($label) . "'";
            }
            if ($date !== null) {
                $fields[] = "date='$date'";
            }

            if (empty($fields)) return false;

            $query = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }
    }
?>