<?php
    namespace App\Models;

    use App\Core\Model;

    class ContactImage extends Model
    {
        protected $table = "contact_images";

        public function create($contact_id, $type, $file_path)
        {
            $type = $this->clean($type);
            $file_path = $this->clean($file_path);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, type, file_path)
                    VALUES ('$contact_id', '$type', '$file_path')";

            $this->executeQuery($query);
            return $this->lastInsertedId();
        }

        public function getByContact($contact_id)
        {
            $contact_id = (int)$contact_id;
            $query = "SELECT * FROM {$this->table} WHERE contact_id = $contact_id";
            return $this->selectQuery($query);
        }
    }
?>