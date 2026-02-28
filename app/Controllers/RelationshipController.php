<?php
    namespace App\Controllers;
    use App\Models\Relationship;

    class RelationshipController {
        public $errors = [];
        public $success = '';
        public $relations = [];
        public $delete_id = null; // For delete modal

        public function index() {
            $relation = new Relationship;

            if(session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Handle delete confirmation POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['confirm_delete_id'])) {
                $delete_id = (int)$_POST['confirm_delete_id'];
                try {
                    $relation->deleteRelation($delete_id);
                    $_SESSION['success'] = "Relation deleted successfully";
                    header("Location: index.php");
                    exit;
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            // Handle Add/Update
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['confirm_delete_id'])) {
                $rel_name = trim($_POST['rel_name']);
                $rel_id   = !empty($_POST['rel_id']) ? (int)$_POST['rel_id'] : null;

                if (empty($rel_name)) {
                    $this->errors[] = "Set a relation name";
                } else {
                    try {
                        $existing = $relation->getByRel($rel_name);
                        if ($existing && $existing['id'] != $rel_id) {
                            $this->errors[] = "This relation already exists";
                        } else {
                            if ($rel_id) {
                                $relation->updateRelation($rel_id, $rel_name);
                                $_SESSION['success'] = "Relation updated successfully";
                            } else {
                                $relation->create($rel_name);
                                $_SESSION['success'] = "Relation created successfully";
                            }
                            $_GET['edit_id'] = null;
                        }
                    } catch (\Exception $e) {
                        $this->errors[] = $e->getMessage();
                    }
                }
            }

            // Relations
            $this->relations = $relation->getAll();

            // Session success
            if (!empty($_SESSION['success'])) {
                $this->success = $_SESSION['success'];
                unset($_SESSION['success']);
            }

            // Delete modal ID if requested via GET
            $this->delete_id = !empty($_GET['delete_id']) ? (int)$_GET['delete_id'] : null;
        }
    }
?>