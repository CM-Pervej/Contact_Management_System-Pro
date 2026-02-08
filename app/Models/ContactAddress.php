<?php
    namespace App\Models;
    use App\Core\Model;

    class ContactAddress extends Model {
        protected $table = "contact_addresses";

        // create address 
        public function create($contact_id, $label, $data) {
            $label      = $this->clean($label ?? '');

            $street     = $this->clean($data['street'] ?? '');
            $city       = $this->clean($data['city'] ?? '');
            $state      = $this->clean($data['state'] ?? '');
            $postal     = $this->clean($data['postal_code'] ?? '');
            $country    = $this->clean($data['country'] ?? '');

            $contact_id = (int)$contact_id;

            $query = "INSERT INTO {$this->table} (contact_id, label, street, city, state, postal_code, country) VALUES ('$contact_id', '$label', '$street', '$city', '$state', '$postal', '$country')";
            $this->executeQuery($query);
            
            return $this->lastInsertedId();
        }

        // get address by contact id 
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

        // delete address 
        public function delete ($id, $contact_id) {
            $id         = (int)$id;
            $contact_id = (int)$contact_id;
            $query      = "DELETE FROM {$this->table} WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }

        // update address 
        public function update($id, $contact_id, $label, $data) {
            $id         = (int)$id;
            $contact_id = (int)$contact_id;

            $fields     = [];
            if($label !== null) {
                $fields[] = "label='" . $this->clean($label) . "'";
            }

            foreach (['street','city','state','postal_code','country'] as $key) {
                if(isset($data[$key])) {
                    $fields[] = "$key='" . $this->clean($data[$key]) . "'";
                }
            }

            if (empty($fields)) return false;

            $query = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id='$id' AND contact_id='$contact_id'";
            return $this->executeQuery($query);
        }
    }
?>