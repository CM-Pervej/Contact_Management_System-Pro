<?php
    namespace App\Models;

    use App\Core\Model;

    class ContactEmail extends Model
    {
        protected $table = "contact_emails";

        public function create($contact_id, $label, $email)
        {
            $label = $this->clean($label);
            $email = $this->clean($email);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, email)
                    VALUES ('$contact_id', '$label', '$email')";

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