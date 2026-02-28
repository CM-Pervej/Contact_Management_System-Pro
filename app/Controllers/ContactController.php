<?php
namespace App\Controllers;

use App\Models\Contact;
use App\Models\ContactPhone;
use App\Models\ContactEmail;
use App\Models\ContactDate;
use App\Models\ContactAddress;
use App\Models\ContactWebsite;
use App\Models\ContactImage;
use App\Models\ContactNote;
use App\Models\Relationship;
use App\Models\ContactRelative;

class ContactController {
    public $errors = [];
    public $success = "";

    /* =========================
       CREATE CONTACT
    ========================= */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return false;

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            $this->errors[] = "Unauthorized access";
            return false;
        }

        if (empty($_POST['first_name'])) {
            $this->errors[] = "First name is required";
            return false;
        }

        $uploadDir = realpath(__DIR__ . '/../../') . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $images = [];
        foreach (['front_image', 'back_image'] as $imgField) {
            if (!empty($_FILES[$imgField]['name'])) {
                $filename = time() . '_' . $imgField . '_' . basename($_FILES[$imgField]['name']);
                $targetPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES[$imgField]['tmp_name'], $targetPath)) {
                    $images[] = [
                        "type" => str_replace('_image','',$imgField),
                        "file_path" => "uploads/" . $filename
                    ];
                } else {
                    $this->errors[] = ucfirst($imgField) . " upload failed";
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
            "notes"          => $_POST['notes'] ?? [],
            "phones"         => $_POST['phones'] ?? [],
            "emails"         => $_POST['emails'] ?? [],
            "dates"          => $_POST['dates'] ?? [],
            "addresses"      => $_POST['addresses'] ?? [],
            "websites"       => $_POST['websites'] ?? [],
            "images"         => $images
        ];

        $contactModel = new Contact();
        $contactId = $contactModel->create($data);
        if (!$contactId) {
            $this->errors[] = "Failed to create contact";
            return false;
        }

        $this->saveModularData($contactId, $data);

        $this->success = "Contact created successfully!";
        return $contactId;
    }

    /* =========================
       INDEX: LIST CONTACTS
    ========================= */
    public function index() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            $this->errors[] = "You must be logged in to view contacts";
            return [];
        }

        $contactModel = new Contact();
        $contacts = $contactModel->getByUserId($userId) ?: [];

        foreach ($contacts as &$c) {
            $this->loadModularData($c);
        }
        return $contacts;
    }

    /* =========================
       SHOW SINGLE CONTACT
    ========================= */
    public function show($id) {
        if (!$id) {
            $this->errors[] = "Contact ID is required";
            return null;
        }

        $contactModel = new Contact();
        $contact = $contactModel->getById($id);
        if (!$contact) {
            $this->errors[] = "Contact not found";
            return null;
        }

        $this->loadModularData($contact);
        
        $relativeModel = new ContactRelative();
        $contact['relatives'] = $relativeModel->getByContact($contact['id']);
        return $contact;
    }

    /* =========================
       UPDATE CONTACT
    ========================= */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return false;

        $userId = (int)$_SESSION['user']['id'] ?? null;
        if (!$userId) {
            $this->errors[] = "Unauthorized access";
            return false;
        }

        $id = (int)$id;
        if (!$id) {
            $this->errors[] = "Contact ID is required";
            return false;
        }

        if (empty($_POST['first_name'])) {
            $this->errors[] = "First name is required";
            return false;
        }

        $contactModel = new Contact();
        $contact = $contactModel->getById($id);

        if (!$contact || (int)$contact['user_id'] !== $userId) {
            $this->errors[] = "Access denied";
            return false;
        }

        $mainData = [
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
            "relation"       => trim($_POST['relation'] ?? "")
        ];

        if (!$contactModel->update($id, $mainData)) {
            $this->errors[] = "Failed to update contact";
            return false;
        }

        // ================= IMAGE UPLOAD (UPDATE) =================
// ================= IMAGE UPLOAD / REPLACE =================
$uploadDir = realpath(__DIR__ . '/../../') . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imageModel = new ContactImage();
$existingImages = $imageModel->getByContactId($id);

foreach (['front_image', 'back_image'] as $imgField) {

    if (empty($_FILES[$imgField]['name'])) continue;

    $filename = time() . '_' . $imgField . '_' . basename($_FILES[$imgField]['name']);
    $targetPath = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES[$imgField]['tmp_name'], $targetPath)) {
        $this->errors[] = ucfirst($imgField) . " upload failed";
        continue;
    }

    $type = str_replace('_image', '', $imgField);
    $filePath = 'uploads/' . $filename;

    $existing = null;
    foreach ($existingImages as $img) {
        if ($img['type'] === $type) {
            $existing = $img;
            break;
        }
    }

    if ($existing) {
        // delete old file
        if (!empty($existing['file_path'])) {
            $oldFile = realpath(__DIR__ . '/../../') . '/' . $existing['file_path'];
            if ($oldFile && file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $imageModel->update($existing['id'], $id, $type, $filePath);
    } else {
        $imageModel->create($id, $type, $filePath);
    }
}

        // Save modular data
        $this->saveModularData($id, [
            "phones" => $_POST['phones'] ?? [],
            "notes" => $_POST['notes'] ?? [],
            "emails" => $_POST['emails'] ?? [],
            "dates" => $_POST['dates'] ?? [],
            "addresses" => $_POST['addresses'] ?? [],
            "websites" => $_POST['websites'] ?? []
        ]);

        $this->success = "Contact updated successfully";
        return true;
    }

    /* =========================
       DELETE CONTACT (SOFT)
    ========================= */
    public function delete($id) {
        $userId = (int)$_SESSION['user']['id'] ?? null;
        if (!$userId) {
            $this->errors[] = "Unauthorized access";
            return false;
        }

        $id = (int)$id;
        if (!$id) {
            $this->errors[] = "Contact ID is required";
            return false;
        }

        $contactModel = new Contact();
        $contact = $contactModel->getById($id);
        if (!$contact || (int)$contact['user_id'] !== $userId) {
            $this->errors[] = "Access denied";
            return false;
        }

        if (!$contactModel->softDelete($id, $userId)) {
            $this->errors[] = "Failed to delete contact";
            return false;
        }

        $this->success = "Contact deleted successfully";
        return true;
    }

    /* =========================
       HELPER: Load Modular Data
    ========================= */
    private function loadModularData(&$contact) {
        $contact['phones']    = (new ContactPhone())->getByContactId($contact['id']);
        $contact['notes']     = (new ContactNote())->getByContactId($contact['id']);
        $contact['emails']    = (new ContactEmail())->getByContactId($contact['id']);
        $contact['dates']     = (new ContactDate())->getByContactId($contact['id']);
        $contact['addresses'] = (new ContactAddress())->getByContactId($contact['id']);
        $contact['websites']  = (new ContactWebsite())->getByContactId($contact['id']);
        $contact['images']    = (new ContactImage())->getByContactId($contact['id']);
    }

    /* =========================
       HELPER: Save Modular Data (CREATE / UPDATE / DELETE)
    ========================= */
    private function saveModularData($contactId, $data) {
        $phoneModel   = new ContactPhone();
        $noteModel    = new ContactNote();
        $emailModel   = new ContactEmail();
        $dateModel    = new ContactDate();
        $addressModel = new ContactAddress();
        $websiteModel = new ContactWebsite();

        // PHONES
        foreach ($data['phones'] ?? [] as $key => $item) {
            if (!empty($item['delete']) && !empty($item['id'])) {
                $phoneModel->delete($item['id'], $contactId);
            } elseif (!empty($item['id'])) {
                $phoneModel->update($item['id'], $contactId, $item['label'], $item['phone']);
            } elseif (!empty($item['phone'])) {
                $phoneModel->create($contactId, $item['label'], $item['phone']);
            }
        }

        // Notes
        // foreach ($data['notes'] ?? [] as $note) {
        //     $note = trim($note);
        //     if ($note !== '') {
        //         $noteModel->create($contactId, $note);
        //     }
        // }

        // NOTES
        foreach ($data['notes'] ?? [] as $item) {

            if (!empty($item['delete']) && !empty($item['id'])) {
                $noteModel->delete($item['id'], $contactId);

            } elseif (!empty($item['id'])) {
                $noteModel->update($item['id'], $contactId, trim($item['note']));

            } elseif (!empty($item['note'])) {
                $noteModel->create($contactId, trim($item['note']));
            }
        }

        // EMAILS
        foreach ($data['emails'] ?? [] as $key => $item) {
            if (!empty($item['delete']) && !empty($item['id'])) {
                $emailModel->delete($item['id'], $contactId);
            } elseif (!empty($item['id'])) {
                $emailModel->update($item['id'], $contactId, $item['label'], $item['email']);
            } elseif (!empty($item['email'])) {
                $emailModel->create($contactId, $item['label'], $item['email']);
            }
        }

        // DATES
        foreach ($data['dates'] ?? [] as $key => $item) {
            if (!empty($item['delete']) && !empty($item['id'])) {
                $dateModel->delete($item['id'], $contactId);
            } elseif (!empty($item['id'])) {
                $dateModel->update($item['id'], $contactId, $item['label'], $item['date']);
            } elseif (!empty($item['date'])) {
                $dateModel->create($contactId, $item['label'], $item['date']);
            }
        }

        // ADDRESSES
        foreach ($data['addresses'] ?? [] as $key => $item) {
            if (!empty($item['delete']) && !empty($item['id'])) {
                $addressModel->delete($item['id'], $contactId);
            } elseif (!empty($item['id'])) {
                $addressModel->update($item['id'], $contactId, $item['label'], $item);
            } elseif (!empty($item['street'])) {
                $addressModel->create($contactId, $item['label'], $item);
            }
        }

        // WEBSITES
        foreach ($data['websites'] ?? [] as $key => $item) {
            $url = trim($item['url'] ?? '');
            $label = trim($item['label'] ?? '');

            if (!empty($item['delete']) && !empty($item['id'])) {
                // Delete existing website
                $websiteModel->delete($item['id'], $contactId);
            } elseif (!empty($item['id'])) {
                // Update existing website
                $websiteModel->update($item['id'], $contactId, $label, $url);
            } elseif ($url !== '') {
                // Create new website only if URL is not empty
                $websiteModel->create($contactId, $label, $url);
            }
        }
    }

    // Get selected relatives for a contact
    public function getRelatives($contactId) {
        $model = new ContactRelative();
        return $model->getByContact($contactId);
    }

public function saveRelatives($contactId, $relatives) {
    $model = new ContactRelative();
    $existing = $model->getByContact($contactId);
    
    // Map existing relatives by relative contact id
    $existingMap = [];
    foreach ($existing as $rel) {
        $existingMap[$rel['relative_id']] = $rel;
    }

    foreach ($relatives as $relId => $data) {
        $isChecked = !empty($data['checked']);
        $relationshipId = (int)($data['relationship_id'] ?? 0);

        if ($isChecked) {
            // If relationship not selected, default to 1 or a "self-defined" value
            if ($relationshipId === 0) $relationshipId = 1;
            if (!isset($existingMap[$relId])) {
                $model->create($contactId, $relId, $relationshipId);
            } else {
                // update existing
                $existingRel = $existingMap[$relId];
                if ($existingRel['relationship_id'] != $relationshipId) {
                    $model->update($existingRel['id'], $relId, $relationshipId);
                }
            }
        } else {
            // unchecked → remove
            if (isset($existingMap[$relId])) {
                $model->delete($existingMap[$relId]['id']);
            }
        }
    }
}
}
?>
