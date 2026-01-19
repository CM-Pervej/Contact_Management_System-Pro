<?php
    namespace App\Models;

    use App\Core\Model;

    class ContactDate extends Model
    {
        protected $table = "contact_dates";

        public function create($contact_id, $label, $date)
        {
            $label = $this->clean($label);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, date)
                    VALUES ('$contact_id', '$label', '$date')";

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