<?php
    require_once "../../vendor/autoload.php";
    $pageTitle = "ContactMS-Pro/Contact List";
    require_once __DIR__ . '/../layout/layout.php';

    use App\Controllers\ContactController;

    $controller = new ContactController();
    $contacts = $controller->index();
    $errors = $controller->errors;

    // Function to get full name string for sorting
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

    // Sort contacts by full name alphabetically
    usort($contacts, function($a, $b) {
        return strcasecmp(getFullName($a), getFullName($b));
    });

    $totalContacts = count($contacts);
?>

<div class="mx-auto p-8">
    <h1 class="text-2xl font-bold mb-2">My Contacts <sup class="font-normal">(<?= $totalContacts ?>)</sup></h1>

    <?php if ($errors): ?>
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($contacts)): ?>
        <p>No contacts found.</p>
    <?php else: ?>
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="pr-4 py-2 text-left font-semibold border-b">Name</th>
                    <th class="px-4 py-2 text-left font-semibold border-b">Emails</th>
                    <th class="px-4 py-2 text-left font-semibold border-b">Phone Numbers</th>
                    <th class="px-4 py-2 text-left font-semibold border-b">Job Title & Company</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr class="hover:bg-blue-50">
                        <td class="pr-4 py-2">
                            <div class="flex items-center gap-5">
                                <?php 
                                $frontImage = '../../uploads/logo.png'; // default fallback
                                if (!empty($contact['images'])) {
                                    foreach ($contact['images'] as $img) {
                                        if ($img['type'] === 'front') {
                                            $frontImage = '../../' . $img['file_path'];
                                            break;
                                        }
                                    }
                                }
                                ?>
                                
                                <img src="<?= htmlspecialchars($frontImage) ?>" alt="Front Image" class="w-10 h-10 object-cover rounded-full border hover:border-gray-400">
                                
                                <span class="font-semibold">
                                    <a href="person.php?id=<?= $contact['id'] ?>" class="hover:text-blue-600">
                                        <?= htmlspecialchars(getFullName($contact)) ?>
                                    </a>
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            <?php if (!empty($contact['emails'])): ?>
                                <select class="block w-full shadow-sm px-3 py-2 bg-white text-sm border border-gray-300 rounded-md">
                                    <?php foreach ($contact['emails'] as $email): ?>
                                        <option value="<?= htmlspecialchars($email['email']) ?>">
                                            <?= htmlspecialchars($email['email']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <span class="text-gray-400">No emails</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2">
                            <?php if (!empty($contact['phones'])): ?>
                                <select class="block w-full shadow-sm px-3 py-2 bg-white text-sm border border-gray-300 rounded-md">
                                    <?php foreach ($contact['phones'] as $phone): ?>
                                        <option value="<?= htmlspecialchars($phone['phone']) ?>">
                                            <?= htmlspecialchars($phone['phone']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <span class="text-gray-400">No phones</span>
                            <?php endif; ?>
                        </td>
                        <!-- Job Title, Department & Company -->
                        <td class="px-4 py-2">
                            <?php if (!empty($contact['title']) || !empty($contact['department']) || !empty($contact['company'])): ?>
                                <select class="block w-full shadow-sm px-3 py-2 bg-white text-sm border border-gray-300 rounded-md">
                                    <?php if (!empty($contact['title'])): ?>
                                        <option value="<?= htmlspecialchars($contact['title']) ?>"><?= htmlspecialchars($contact['title']) ?></option>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($contact['department'])): ?>
                                        <option value="<?= htmlspecialchars($contact['department']) ?>"><?= htmlspecialchars($contact['department']) ?></option>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($contact['company'])): ?>
                                        <option value="<?= htmlspecialchars($contact['company']) ?>"><?= htmlspecialchars($contact['company']) ?></option>
                                    <?php endif; ?>
                                </select>
                            <?php else: ?>
                                <span class="text-gray-400">No job info</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
