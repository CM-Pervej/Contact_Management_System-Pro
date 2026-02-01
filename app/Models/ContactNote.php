<?php
namespace App\Models;
use App\Core\Model;

class ContactNote extends Model{
    protected $table = "contact_notes";

    public function create($contact_id, $note) {
        $contact_id = (int)$contact_id;
        $note = $this->clean($note);

        $query = "INSERT INTO {$this->table} (contact_id, note)
                  VALUES ('$contact_id', '$note')";

        $this->executeQuery($query);
        return $this->lastInsertedId();
    }

    public function getByContact($contact_id) {
        $contact_id = (int)$contact_id;
        $query = "SELECT * FROM {$this->table} WHERE contact_id = $contact_id";
        return $this->selectQuery($query);
    }
}