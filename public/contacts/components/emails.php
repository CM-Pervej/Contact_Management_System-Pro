<div class="flex">
    <div class="w-40">✉️ <span class="text-sm text-gray-500 ml-1">Email</span></div>
    <div class="text-sm space-y-1">
        <?php if (!empty($contact['emails'])): ?>
            <?php foreach ($contact['emails'] as $email): ?>
                <div>
                    <a href="mailto:<?= htmlspecialchars($email['email']) ?>" class="text-blue-600 hover:underline">
                        <?= htmlspecialchars($email['email']) ?>
                    </a>
                    <span class="text-gray-400 mx-1">•</span>
                    <span class="text-gray-500 text-xs"><?= htmlspecialchars($email['label']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-400">No emails</div>
        <?php endif; ?>
    </div>
</div>
