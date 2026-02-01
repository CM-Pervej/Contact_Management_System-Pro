<?php
    namespace App\Models;
    use App\Core\Model;

    class Contact extends Model {
        protected $table = 'contacts';

        // create contact
        public function create ($data) {
            $first = $this->clean($data['first_name']);
            $middle = $this->clean($data['middle_name']);
            $last = $this->clean($data['last_name']);
            $nickname = $this->clean($data['nickname']);
            $phonetic_first = $this->clean($data['phonetic_first']);
            $phonetic_last = $this->clean($data['phonetic_last']);
            $suffix = $this->clean($data['name_suffix']);
            $prefix = $this->clean($data['name_prefix']);

            $company = $this->clean($data['company']);
            $department = $this->clean($data['department']);
            $title = $this->clean($data['title']);
            $relation = $this->clean($data['relation']);

            $user_id = (int)$data['user_id'];

            $query = "INSERT INTO {$this->table} 
                (user_id, first_name, middle_name, last_name, nickname, phonetic_first, phonetic_last,name_suffix, name_prefix, company, department, title, relation)
                VALUES 
                ('$user_id', '$first', '$middle', '$last', '$nickname', '$phonetic_first', '$phonetic_last', '$suffix', '$prefix', '$company', '$department', '$title', '$relation')";

            $this->executeQuery($query);
            return $this->lastInsertedId();
        }

        // Get contact by Id 
        public function getById($id) {
            $id = (int) $id;
            $query = "SELECT * FROM {$this->table} WHERE id = $id AND is_deleted = 0 LIMIT 1";
            return $this->selectQuery($query)->fetch_assoc();
        }

        // Get All contact
        public function getAll($user_id) {
            $user_id = (int) $user_id;
            $query = "SELECT * FROM {$this->table} WHERE user_id = $user_id AND is_deleted = 0 ORDER BY first_name";
            return $this->selectQuery($query);
        }
    }
?>