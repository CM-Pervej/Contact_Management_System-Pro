<?php
    namespace App\Controllers;

    use App\Models\Contact;
    use App\Models\ContactPhone;
    use App\Models\ContactEmail;
    use App\Models\ContactDate;
    use App\Models\ContactAddress;
    use App\Models\ContactWebsite;
    use App\Models\ContactImage;

    class ContactController
    {
        public $errors = [];
        public $success = "";

        /**
         * CREATE NEW CONTACT
         */
        public function store($data)
        {
            $contactModel = new Contact();

            // 1. Insert main contact
            $contact_id = $contactModel->create($data);

            if (!$contact_id) {
                $this->errors[] = "Failed to create contact";
                return false;
            }

            // Load sub-models
            $phoneModel   = new ContactPhone();
            $emailModel   = new ContactEmail();
            $dateModel    = new ContactDate();
            $addressModel = new ContactAddress();
            $websiteModel = new ContactWebsite();
            $imageModel   = new ContactImage();

            /** INSERT PHONES */
            if (!empty($data['phones'])) {
                foreach ($data['phones'] as $item) {
                    if (!empty($item['phone'])) {
                        $phoneModel->create($contact_id, $item['label'], $item['phone']);
                    }
                }
            }

            /** INSERT EMAILS */
            if (!empty($data['emails'])) {
                foreach ($data['emails'] as $item) {
                    if (!empty($item['email'])) {
                        $emailModel->create($contact_id, $item['label'], $item['email']);
                    }
                }
            }

            /** INSERT DATES */
            if (!empty($data['dates'])) {
                foreach ($data['dates'] as $item) {
                    if (!empty($item['date'])) {
                        $dateModel->create($contact_id, $item['label'], $item['date']);
                    }
                }
            }

            /** INSERT ADDRESSES */
            if (!empty($data['addresses'])) {
                foreach ($data['addresses'] as $item) {
                    if (!empty($item['street'])) {
                        $addressModel->create($contact_id, $item['label'], $item);
                    }
                }
            }

            /** INSERT WEBSITES */
            if (!empty($data['websites'])) {
                foreach ($data['websites'] as $item) {
                    if (!empty($item['url'])) {
                        $websiteModel->create($contact_id, $item['label'], $item['url']);
                    }
                }
            }

            /** INSERT IMAGES */
            if (!empty($data['images'])) {
                foreach ($data['images'] as $item) {
                    if (!empty($item['file_path'])) {
                        $imageModel->create($contact_id, $item['type'], $item['file_path']);
                    }
                }
            }

            $this->success = "Contact created successfully!";
            return $contact_id;
        }
    }
?>
