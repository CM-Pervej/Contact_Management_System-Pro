<?php
    namespace App\Models;

    use App\Core\Model;

    class ContactWebsite extends Model
    {
        protected $table = "contact_websites";

        public function create($contact_id, $label, $url)
        {
            $label = $this->clean($label);
            $url = $this->clean($url);
            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, url)
                    VALUES ('$contact_id', '$label', '$url')";

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