<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactNote extends Model{
        protected $table = "contact_notes";

        public function create($contact_id, $note) {
            $contact_id = (int)$contact_id;
            $note       = $this->clean($note);

            $query = "INSERT INTO {$this->table} (contact_id, note) VALUES ('$contact_id', '$note')";
            $this->executeQuery($query);

            return $this->lastInsertedId();
        }

        // get notes by contact id 
        public function getByContactId($contact_id) {
            $contact_id = (int)$contact_id;
            $query      = "SELECT * FROM {$this->table} WHERE contact_id = $contact_id";
            $result     = $this->selectQuery($query);

            $rows       = [];
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }

        // delete notes 
        public function delete ($id, $contact_id) {
            $id         = (int)$id;
            $contact_id = (int)$contact_id;
            $query      = "DELETE FROM {$this->table} WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }

        // update notes 
        public function update($id, $contact_id, $note) {
            $id         = (int)$id;
            $contact_id = (int)$contact_id;
            $note       = $this->clean($note);

            $query = "UPDATE {$this->table} SET note='$note' WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }
    }
?>