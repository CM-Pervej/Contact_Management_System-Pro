<div class="flex">
    <div class="w-40">📍 <span class="text-sm text-gray-500 ml-1">Location</span></div>
    <div class="text-sm space-y-3">
        <?php if (!empty($contact['addresses'])): ?>
            <?php foreach ($contact['addresses'] as $addr): ?>
                <div class="text-gray-800 leading-snug">
                    <?= htmlspecialchars($addr['street']) ?>
                    <?= !empty($addr['postal_code']) ? ', ' . htmlspecialchars($addr['postal_code']) : '' ?>
                    <?= !empty($addr['city']) ? ', ' . htmlspecialchars($addr['city']) : '' ?>
                    <?= !empty($addr['state']) ? ', ' . htmlspecialchars($addr['state']) : '' ?>
                    <?= !empty($addr['country']) ? ', ' . htmlspecialchars($addr['country']) : '' ?>
                    <?php if (!empty($addr['label'])): ?>
                        <span class="text-gray-400 mx-1">•</span>
                        <span class="text-gray-500 text-xs"><?= htmlspecialchars($addr['label']) ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-400">No addresses</div>
        <?php endif; ?>
    </div>
</div>
