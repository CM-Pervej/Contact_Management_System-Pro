<?php
require_once "../../vendor/autoload.php";
$pageTitle = "ContactMS-Pro/Edit Contact";
require_once __DIR__ . '/../layout/layout.php';

use App\Controllers\ContactController;


$contactId = $_GET['id'] ?? null;
$controller = new ContactController();
$success = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_contact'])) {
        if ($controller->update($contactId)) {
            $success = $controller->success;
            header("Location: person.php?id=$contactId"); // redirect after update
            exit;
        } else {
            $errors = $controller->errors;
        }
    }
    if (isset($_POST['delete_contact'])) {
        if ($controller->delete($contactId)) {
            header("Location: index.php"); // redirect after delete
            exit;
        } else {
            $errors = $controller->errors;
        }
    }
}

// Load contact for display
$contact = $controller->show($contactId);

// Helper: Full Name
function getFullName($contact) {
    $parts = [];
    if (!empty($contact['name_prefix'])) $parts[] = $contact['name_prefix'];
    if (!empty($contact['first_name'])) $parts[] = $contact['first_name'];
    if (!empty($contact['middle_name'])) $parts[] = $contact['middle_name'];
    if (!empty($contact['last_name'])) $parts[] = $contact['last_name'];
    if (!empty($contact['name_suffix'])) $parts[] = $contact['name_suffix'];
    if (!empty($contact['nickname'])) $parts[] = "({$contact['nickname']})";
    return implode(' ', $parts);
}


?>

<section class="mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars(getFullName($contact)) ?></h1>

    <?php if ($errors): ?>
        <div class="bg-red-100 text-red-700 p-4 mb-6 rounded">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-4 mb-6 rounded">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($contact): ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- MAIN CONTACT INFO -->
            <div class="card bg-base-100 bg-gray-200">
                <div class="card-body space-y-6">
                    <!-- NAME SECTION -->
                    <div>
                        <h2 class="text-lg font-bold mb-3 animate-shimmer animate-float">👤 Name Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="name_prefix" placeholder="Prefix" value="<?= htmlspecialchars($contact['name_prefix'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="first_name" placeholder="First Name" value="<?= htmlspecialchars($contact['first_name'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="middle_name" placeholder="Middle Name" value="<?= htmlspecialchars($contact['middle_name'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($contact['last_name'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="nickname" placeholder="Nickname" value="<?= htmlspecialchars($contact['nickname'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="name_suffix" placeholder="Suffix" value="<?= htmlspecialchars($contact['name_suffix'] ?? '') ?>" class="input input-bordered w-full" />
                        </div>
                    </div>

                    <!-- WORK SECTION -->
                    <div>
                        <h2 class="text-lg font-bold mb-3 animate-shimmer animate-float">🏢 Work Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="company" placeholder="Company" value="<?= htmlspecialchars($contact['company'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="department" placeholder="Department" value="<?= htmlspecialchars($contact['department'] ?? '') ?>" class="input input-bordered w-full" />
                            <input type="text" name="title" placeholder="Job Title" value="<?= htmlspecialchars($contact['title'] ?? '') ?>" class="input input-bordered w-full" />
                        </div>
                    </div>

                    <!-- RELATION -->
                    <div>
                        <h2 class="text-lg font-bold mb-3 animate-shimmer animate-float">🤝 Relationship</h2>
                        <input type="text" name="relation" placeholder="Relation (Friend, Client, Family)" value="<?= htmlspecialchars($contact['relation'] ?? '') ?>" class="input input-bordered w-full md:w-1/2" />
                    </div>
                </div>
            </div>

            <section class="flex flex-col gap-5">
                <div class="flex flex-col lg:flex-row gap-5">
                    <div class="w-full"> <?php include __DIR__ . '/Components/phones_edit.php'; ?> </div>
                    <div class="w-full"> <?php include __DIR__ . '/Components/emails_edit.php'; ?> </div>
                </div>
                <div class="w-full"> <?php include __DIR__ . '/Components/addresses_edit.php'; ?> </div>
                <div class="flex flex-col lg:flex-row gap-5">
                    <div class="w-full"> <?php include __DIR__ . '/Components/dates_edit.php'; ?> </div>
                    <div class="w-full"> <?php include __DIR__ . '/Components/websites_edit.php'; ?> </div>
                </div>
                <div class="w-full"> <?php include __DIR__ . '/Components/notes_edit.php'; ?> </div>
                <div class="w-full"> <?php include __DIR__ . '/Components/photos_edit.php'; ?> </div>
            </section>

            <!-- ACTIONS -->
            <div class="mt-6 space-x-3">
                <button type="submit" name="update_contact" class="bg-green-600 text-white px-4 py-2 rounded">Save Changes</button>
                <button type="submit" name="delete_contact" onclick="return confirm('Are you sure?');" class="bg-red-600 text-white px-4 py-2 rounded">Delete Contact</button>
            </div>
        </form>
    <?php endif; ?>
</section>
<style>
    /* Shimmer animation */
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    .animate-shimmer {
        background-size: 200% auto;
        background-clip: text;
        -webkit-background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    /* Floating animation */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    .animate-float {
        animation: float 2s ease-in-out infinite;
    }
</style>

<!-- JS: Delete modular rows -->
<script>
document.addEventListener('click', function(e){
    const btn = e.target.closest('.delete-btn'); // look for closest ancestor with class
    if(btn){
        e.preventDefault(); // prevent accidental default click (only affects delete)
        const row = btn.closest('div');
        if(!row) return;

        const hiddenId = row.querySelector('input[type="hidden"][name*="[id]"]'); // existing id input
        if(hiddenId){
            // mark as deleted
            const name = hiddenId.name.replace('[id]','[delete]');
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = name;
            deleteInput.value = 1;
            row.appendChild(deleteInput);
        }
        // visually hide the row
        row.style.display = 'none';
    }
});
</script>
<?php require_once '../layout/footer.php'; ?>