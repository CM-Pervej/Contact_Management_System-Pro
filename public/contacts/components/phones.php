<div class="flex">
    <div class="w-40">📞 <span class="text-sm text-gray-500 ml-1">Phone</span></div>
    <div class="text-sm space-y-1">
        <?php if (!empty($contact['phones'])): ?>
            <?php foreach ($contact['phones'] as $phone):
                $rawPhone = $phone['phone'];
                $telPhone = preg_replace('/[^0-9+]/', '', $rawPhone);
            ?>
                <div>
                    <a href="tel:<?= htmlspecialchars($telPhone) ?>" class="text-blue-600 hover:underline">
                        <?= htmlspecialchars($rawPhone) ?>
                    </a>
                    <span class="text-gray-400 mx-1">•</span>
                    <span class="text-gray-500 text-xs"><?= htmlspecialchars($phone['label']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-400">No phones</div>
        <?php endif; ?>
    </div>
</div>
