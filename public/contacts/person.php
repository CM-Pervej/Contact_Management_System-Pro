<?php
    require_once "../../vendor/autoload.php";
    // $pageTitle = "ContactMS-Pro/Contact Details";
    // require_once __DIR__ . '/../layout/layout.php';

    use App\Controllers\ContactController;
    use App\Models\Relationship;

    $contactId = $_GET['id'] ?? null; // get id from URL
    $controller = new ContactController();
    $contact = $controller->show($contactId);
    $errors = $controller->errors;

    // Helper: Full name
    function getFullName($contact) {
        $parts = [];
        if (!empty($contact['name_prefix'])) $parts[] = $contact['name_prefix'];
        if (!empty($contact['first_name'])) $parts[] = $contact['first_name'];
        if (!empty($contact['middle_name'])) $parts[] = $contact['middle_name'];
        if (!empty($contact['last_name'])) $parts[] = $contact['last_name'];
        if (!empty($contact['name_suffix'])) $parts[] = ", {$contact['name_suffix']}";
        if (!empty($contact['nickname'])) $parts[] = "({$contact['nickname']})";
        return implode(' ', $parts);
    }

    // Fetch relationships mapping
    $relationshipModel = new Relationship();
    $relationships = [];
    foreach ($relationshipModel->getAll() as $rel) {
        $relationships[$rel['id']] = $rel['rel_name'];
    }


    $pageTitle = htmlspecialchars(getFullName($contact));
    require_once __DIR__ . '/../layout/layout.php';
?>

<section class="mx-auto">
    <?php if ($errors): ?>
        <div class="bg-red-100 text-red-700 p-4 mb-6 rounded">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php elseif ($contact): ?>

    <!-- HEADER -->
    <?php include __DIR__ . '/components/header.php'; ?>

    <section class="flex flex-col lg:flex-row">
        <!-- CONTACT INFO -->
        <div class="space-y-3 px-8 mb-5 flex-1">
            <h2 class="text-sm font-medium text-gray-500">Contact information</h2>
            <?php include __DIR__ . '/Components/emails.php'; ?>
            <?php include __DIR__ . '/Components/phones.php'; ?>
            <h2 class="text-sm font-medium text-gray-500 mb-4">Address</h2>
            <?php include __DIR__ . '/Components/addresses.php'; ?>
            <h2 class="text-sm font-medium text-gray-500 mb-4">Dates</h2>
            <?php include __DIR__ . '/Components/dates.php'; ?>
            <h2 class="text-sm font-medium text-gray-500 mb-4">Websites</h2>
            <?php include __DIR__ . '/Components/websites.php'; ?>
            <h2 class="text-sm font-medium text-gray-500 mb-4">Others</h2>
            <?php include __DIR__ . '/Components/notes.php'; ?>
        </div>
        <div class="space-y-3 px-8 mb-5 flex-1">
            <h2 class="text-sm font-medium text-gray-500">Relatives</h2>
            <?php if (!empty($contact['relatives'])): ?>
                <div class="grid grid-cols-1 gap-4">
                    <?php foreach ($contact['relatives'] as $rel):
                        $relative = $controller->show($rel['relative_id']);
                        $imgPath = $relative['images'][0]['file_path'] ?? 'uploads/logo.png';
                        $fullName = getFullName($relative);
                        $relationName = $relationships[$rel['relationship_id']] ?? 'Relation';
                    ?>
                        <div class="bg-white p-4 rounded shadow flex items-center space-x-3">
                            <img src="../../<?= htmlspecialchars($imgPath) ?>" class="w-16 h-16 rounded-full object-cover border border-black">
                            <div>
                                <a href="person.php?id=<?= $rel['relative_id'] ?>" class="font-semibold text-blue-600 hover:underline">
                                    <?= htmlspecialchars($fullName) ?>
                                </a>
                                <div class="text-sm text-gray-500"><?= htmlspecialchars($relationName) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No relatives Selected.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
</section>
