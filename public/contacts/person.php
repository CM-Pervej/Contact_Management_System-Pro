<?php
    require_once "../../vendor/autoload.php";

    use App\Controllers\ContactController;

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
    <?php include __DIR__ . '/Components/header.php'; ?>

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
        </div>
    </section>
    <?php endif; ?>
</section>
