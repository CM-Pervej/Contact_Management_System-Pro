<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactPhone extends Model {
        protected $table = 'contact_phones';

        public function create($contact_id, $label, $phone){
            $label = $this->clean($label);
            $phone = $this->clean($phone);
            $contact_id = $this->clean($contact_id);

            $query = "INSERT INTO {$this->table} (contact_id, label, phone) VALUES ('$contact_id', '$label', '$phone')";

            $this->executeQuery($query);
            return $this->lastInsertedId();
        }

        public function getByContact($contact_id){       
            $contact_id = (int)$contact_id;
            $query = "SELECT * FROM {$this->table} WHERE contact_id = $contact_id";
            return $this->selectQuery($query);
        }
    }
?>