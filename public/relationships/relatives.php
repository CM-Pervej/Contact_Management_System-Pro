<?php
require_once "../../vendor/autoload.php";
$pageTitle = "Manage Relatives";
require_once __DIR__ . '/../layout/layout.php';

use App\Controllers\ContactController;
use App\Models\Contact;
use App\Models\Relationship;
use App\Models\ContactPhone;
use App\Models\ContactEmail;
use App\Models\ContactImage;

$contactId = $_GET['id'] ?? null;
if (!$contactId) die('Contact ID missing');

$controller = new ContactController();
$contact = $controller->show($contactId);

// Fetch all user contacts
$contactModel = new Contact();
$allContacts = $contactModel->getByUserId($_SESSION['user']['id']);

// Fetch existing relatives
$existingRelatives = $controller->getRelatives($contactId);
$existingMap = [];
foreach ($existingRelatives as $rel) {
    $existingMap[$rel['relative_id']] = $rel['relationship_id'];
}

// Fetch relationships
$relationshipModel = new Relationship();
$relationships = $relationshipModel->getAll();

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['relatives'])) {
    $controller->saveRelatives($contactId, $_POST['relatives']);
    header("Location: relatives.php?id=$contactId");
    exit;
}

// Optional search
$search = trim($_GET['q'] ?? '');
$filtered = array_filter($allContacts, function($c) use($contactId, $search){
    if ($c['id'] == $contactId) return false;
    if ($search === '') return true;
    return stripos($c['first_name'].' '.$c['last_name'], $search) !== false;
});
?>

<form method="get" class="mb-4">
    <input type="hidden" name="id" value="<?= $contactId ?>">
    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search contacts..." class="border px-3 py-2 rounded w-64">
</form>

<form method="post">
<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th>Select</th>
            <th>Name & Image</th>
            <th>Phones</th>
            <th>Emails</th>
            <th>Relationship</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($filtered as $c):
        $isChecked = isset($existingMap[$c['id']]);
        $selectedRel = $isChecked ? $existingMap[$c['id']] : '';

        // Fetch phones, emails, images
        $phones = (new ContactPhone())->getByContactId($c['id']);
        $emails = (new ContactEmail())->getByContactId($c['id']);
        $images = (new ContactImage())->getByContactId($c['id']);
        $imgPath = $images[0]['file_path'] ?? 'uploads/logo.png';

        $fullName = trim(($c['name_prefix'].' '.$c['first_name'].' '.$c['middle_name'].' '.$c['last_name'].' '.$c['name_suffix'].' '.$c['nickname']));
    ?>
        <tr class="border-t">
            <td class="text-center">
                <input type="checkbox" name="relatives[<?= $c['id'] ?>][checked]" value="1" <?= $isChecked ? 'checked' : '' ?>>
            </td>
            <td class="p-2 flex items-center space-x-2">
                <img src="../../<?= htmlspecialchars($imgPath) ?>" class="w-12 h-12 rounded-full object-cover">
                <div><?= htmlspecialchars($fullName) ?></div>
            </td>
            <td>
                <select class="border px-2 py-1 rounded">
                    <?php foreach ($phones as $p): ?>
                        <option><?= htmlspecialchars($p['phone']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select class="border px-2 py-1 rounded">
                    <?php foreach ($emails as $e): ?>
                        <option><?= htmlspecialchars($e['email']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="relatives[<?= $c['id'] ?>][relationship_id]" class="border rounded px-2 py-1" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($relationships as $rel): ?>
                        <option value="<?= $rel['id'] ?>" <?= $rel['id']==$selectedRel ? 'selected' : '' ?>>
                            <?= htmlspecialchars($rel['rel_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Save Relatives</button>
</form>