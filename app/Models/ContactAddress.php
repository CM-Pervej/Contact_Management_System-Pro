<?php
    namespace App\Models;

    use App\Core\Model;

    class ContactAddress extends Model
    {
        protected $table = "contact_addresses";

        public function create($contact_id, $label, $data)
        {
            $label = $this->clean($label);

            $street = $this->clean($data['street']);
            $city = $this->clean($data['city']);
            $state = $this->clean($data['state']);
            $postal = $this->clean($data['postal_code']);
            $country = $this->clean($data['country']);

            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, street, city, state, postal_code, country) VALUES ('$contact_id', '$label', '$street', '$city', '$state', '$postal', '$country')";

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