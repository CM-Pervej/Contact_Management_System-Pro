<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactImage extends Model {
        protected $table = "contact_images";

        public function create($contact_id, $type, $file_path) {
            $type = $this->clean($type);
            $file_path = $this->clean($file_path);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, type, file_path)
                    VALUES ('$contact_id', '$type', '$file_path')";

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
            $id = (int)$id;
            $contact_id = (int)$contact_id;

            $query = "DELETE FROM {$this->table} 
                    WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }

        public function update($id, $contact_id, $type, $file_path){
            $id = (int)$id;
            $contact_id = (int)$contact_id;

            $fields = [];
            if ($type !== null) {
                $fields[] = "type='" . $this->clean($type) . "'";
            }
            if ($file_path !== null) {
                $fields[] = "file_path='" . $this->clean($file_path) . "'";
            }

            if (empty($fields)) return false;

            $query = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }
    }
?>