<div class="flex">
    <div class="w-40">📅 <span class="text-sm text-gray-500 ml-1">Important</span></div>
    <div class="text-sm space-y-2">
        <?php if (!empty($contact['dates'])): ?>
            <?php foreach ($contact['dates'] as $d): ?>
                <div class="text-gray-800">
                    <?= date('F d, Y', strtotime($d['date'])) ?>
                    <span class="text-gray-400 mx-1">•</span>
                    <span class="text-gray-500 text-xs"><?= htmlspecialchars($d['label']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-400">No dates</div>
        <?php endif; ?>
    </div>
</div>
