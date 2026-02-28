<?php
    // Default front and back images
    $frontImage = '../../uploads/logo.png';
    $backImage  = '../../uploads/logo.png'; // fallback background

    if (!empty($contact['images'])) {
        foreach ($contact['images'] as $img) {
            if ($img['type'] === 'front') {
                $frontImage = '../../' . $img['file_path'];
            } elseif ($img['type'] === 'back') {
                $backImage = '../../' . $img['file_path'];
            }
        }
    }
?>

<div class="relative w-full mb-12">
    <!-- BACK IMAGE -->
     <section class="flex bg-gradient-to-b from-gray-100 via-gray-50 to-white">
         <div class="w-full h-96 relative overflow-auto rounded-tr-3xl">
             <img src="<?= htmlspecialchars($backImage) ?>" alt="Background" class="w-full h-full object-cover brightness-75">
             <div class="absolute inset-0 bg-black bg-opacity-25"></div>
         </div>
         <div class="w-80 justify-center items-center hidden sm:flex">
            <?php require_once __DIR__ . '/watch.php'; ?>
         </div>
     </section>

    <!-- CONTENT -->
    <div class="relative -mt-20 flex flex-col md:flex-row items-center md:items-end px-6 md:px-8">
        <!-- FRONT IMAGE -->
        <div class="w-40 h-40 rounded-full border-4 border-white shadow-lg overflow-hidden flex-shrink-0">
            <img src="<?= htmlspecialchars($frontImage) ?>" alt="Profile" class="w-full h-full object-cover">
        </div>

        <section class="relative flex justify-between items-center w-full">
            <!-- NAME & JOB INFO -->
            <div class="mt-4 md:mt-0 md:ml-6 flex-1 flex flex-col items-center md:items-start space-y-1 text-center md:text-left">
                <h1 class="text-2xl font-bold leading-tight text-gray-900"> <?= htmlspecialchars(getFullName($contact)) ?> </h1>
                <?php if (!empty($contact['title']) || !empty($contact['department']) || !empty($contact['company'])): ?>
                    <div class="text-gray-800">
                        <?= !empty($contact['title']) ? htmlspecialchars($contact['title']) : '' ?>
                        <?= !empty($contact['department']) ? ' • ' . htmlspecialchars($contact['department']) : '' ?>
                        <?= !empty($contact['company']) ? ' • ' . htmlspecialchars($contact['company']) : '' ?>
                    </div>
                <?php else: ?>
                    <div class="text-gray-500">No job info</div>
                <?php endif; ?>
            </div>

            <!-- DESKTOP ACTION BUTTONS -->
            <div class="hidden lg:flex items-center gap-2">
                <!-- ADD -->
                <a href="/contact/public/relationships/relatives.php?id=<?= $contact['id'] ?? '' ?>" class="btn btn-sm btn-outline btn-success shadow-md hover:shadow-lg transition gap-1"> ➕ Add </a>
                <!-- EDIT -->
                <a href="edit.php?id=<?= $contact['id'] ?? '' ?>" class="btn btn-sm btn-outline btn-primary shadow-md hover:shadow-lg transition gap-1"> ✏️ Edit </a>
            </div>

            <!-- MOBILE FLOATING ACTION BUTTONS -->
            <div class="lg:hidden fixed bottom-6 right-6 z-40 flex flex-col gap-3">
                <!-- ADD -->
                <a href="/contact/public/relationships/relatives.php?id=<?= $contact['id'] ?? '' ?>" class="btn btn-success btn-circle shadow-xl flex items-center justify-center hover:scale-105 transition tooltip tooltip-left" data-tip="Add Contact">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <!-- EDIT -->
                <a href="edit.php?id=<?= $contact['id'] ?? '' ?>" class="btn btn-primary btn-circle shadow-xl flex items-center justify-center hover:scale-105 transition tooltip tooltip-left" data-tip="Edit Contact">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6-6M3 21h6l9-9" />
                    </svg>
                </a>
            </div>
        </section>
    </div>
</div>
