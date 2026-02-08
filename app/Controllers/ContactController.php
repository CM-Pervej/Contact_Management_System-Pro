<?php
    namespace App\Controllers;

    use App\Models\Contact;
    use App\Models\ContactPhone;
    use App\Models\ContactEmail;
    use App\Models\ContactDate;
    use App\Models\ContactAddress;
    use App\Models\ContactWebsite;
    use App\Models\ContactNote;
    use App\Models\ContactImage;

    class ContactController {
        public $errors = [];
        public $success = "";

        /** create main contact */
        public function create() {
            if($_SERVER['REQUEST_METHOD'] !== 'POST') return false;

            $userId = $_SESSION['user']['id'] ?? null;
            if(!$userId) {
                $this->errors[] = "Unauthorized access";
                return false;
            }

            if(empty($_POST['first_name'])) {
                $this->errors[] = "First name is required";
            }

            $uploadDir = realpath(__DIR__ . '/../../') . '/uploads/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $images = [];
            foreach (['front_image', 'back_image'] as $imgField) {
                if(!empty($_FILES[$imgField]['name'])) {
                    $filename = time() . '_' . $imgField . '_' .basename($_FILES[$imgField]['name']);
                    $targetPath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES[$imgField]['tmp_name'], $targetPath)) {
                        $images[] = [
                            "type" => str_replace('_image', '', $imgField),
                            "file_path" => "uploads/" . $filename
                        ];
                    } else {
                        $this->errors[] = ucfirst($imgField) . " Upload failed";
                    }
                }
            }

            $data = [
                "user_id"        => $userId,
                "first_name"     => trim($_POST['first_name']),
                "middle_name"    => trim($_POST['middle_name'] ?? ""),
                "last_name"      => trim($_POST['last_name'] ?? ""),
                "nickname"       => trim($_POST['nickname'] ?? ""),
                "phonetic_first" => trim($_POST['phonetic_first'] ?? ""),
                "phonetic_last"  => trim($_POST['phonetic_last'] ?? ""),
                "name_prefix"    => trim($_POST['name_prefix'] ?? ""),
                "name_suffix"    => trim($_POST['name_suffix'] ?? ""),
                "company"        => trim($_POST['company'] ?? ""),
                "department"     => trim($_POST['department'] ?? ""),
                "title"          => trim($_POST['title'] ?? ""),
                "relation"       => trim($_POST['relation'] ?? ""),
                "phones"         => $_POST['phones'] ?? [],
                "emails"         => $_POST['emails'] ?? [],
                "dates"          => $_POST['dates'] ?? [],
                "addresses"      => $_POST['addresses'] ?? [],
                "websites"       => $_POST['websites'] ?? [],
                "notes"          => $_POST['notes'] ?? [],
                "images"         => $images
                ];

            $contactModel = new Contact();
            $contactId = $contactModel->create($data);
            if (!$contactId) {
                $this->errors[] = "Failed to create contact";
                return false;
            }

            // find it to the last 
            $this->saveModularData($contactId, $data);

            $this->success = "Contact created successfully!";
            return $contactId;
        }

        /** show all contact */
        public function index(){
            $userId = $_SESSION['user']['id'] ?? null;
            if(!$userId) {
                $this->errors[] = "You must be loggedin to viw contacts";
                return [];
            }

            $contactModel = new Contact();
            $contacts = $contactModel->getByUserId($userId) ?: [];

            foreach($contacts as $c) {
                $this->loadModularData($c);
            }

            return $contacts;
        }

        /** Show Single Contact */
        public function show($id) {
            if(!$id) {
                $this->errors[] = "Contact ID is required";
                return null;
            }

            $contactModel = new Contact();
            $contact = $contactModel->getById($id);
            if(!$contact) {
                $this->errors[] = "Contact not found";
                return null;
            }

            $this->loadModularData($contact);
            return $contact;
        }

        /** Helper: Load Modular Data */
        private function loadModularData($contact) {
            $contact['phones']      = (new ContactPhone())->getByContactId($contact['id']);
            $contact['emails']      = (new ContactEmail())->getByContactId($contact['id']);
            $contact['dates']       = (new ContactDate())->getByContactId($contact['id']);
            $contact['addresses']   = (new ContactAddress())->getByContactId($contact['id']);
            $contact['websites']    = (new ContactWebsite())->getByContactId($contact['id']);
            $contact['images']      = (new ContactImage())->getByContactId($contact['id']);
        }

        /** Helper: Manage Modular Data (Create / Update / Delete) */
        private function saveModularData($contactId, $data) {
            $phoneModel     = new ContactPhone();
            $emailModel     = new ContactEmail();
            $dateModel      = new ContactDate();
            $addressModel   = new ContactAddress();
            $websiteModel   = new ContactWebsite();
            $NoteModel      = new ContactNote();

            // Phones
            foreach($data['phones'] ?? [] as $key => $item) {
                if(!empty($item['phone'])) {
                    $phoneModel->create($contactId, $item['label'], $item['phone']);
                }
            }

            // Emails
            foreach($data['emails'] ?? [] as $key => $item) {
                if(!empty($item['email'])) {
                    $emailModel->create($contactId, $item['label'], $item['email']);
                }
            }

            // Dates
            foreach($data['dates'] ?? [] as $key => $item) {
                if(!empty($item['date'])) {
                    $dateModel->create($contactId, $item['label'], $item['date']);
                }
            }

            // Addresses
            foreach($data['addresses'] ?? [] as $key => $item) {
                if(!empty($item['street'])) {
                    $addressModel->create($contactId, $item['label'], $item);
                }
            }

            // Addresses
            foreach($data['websites'] ?? [] as $key => $item) {
                if(!empty($item['url'])) {
                    $websiteModel->create($contactId, $item['label'], $item['url']);
                }
            }

            // Notes
            foreach ($data['notes'] ?? [] as $note) {
                $note = trim($note);
                if ($note !== '') {
                    $NoteModel->create($contactId, $note);
                }
            }
        }
    }
?>
