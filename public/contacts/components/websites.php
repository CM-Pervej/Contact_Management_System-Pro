<div class="flex">
    <div class="w-40">🔗 <span class="text-sm text-gray-500 ml-1">Links</span></div>
    <div class="flex flex-col space-y-2 text-sm">
        <?php if (!empty($contact['websites'])): ?>
            <?php foreach ($contact['websites'] as $web): ?>
                <div>
                    <a href="<?= htmlspecialchars($web['url']) ?>" target="_blank" class="text-blue-600 hover:underline">
                        <?= htmlspecialchars($web['url']) ?>
                    </a>
                    <?php if (!empty($web['label'])): ?>
                        <span class="text-gray-400 mx-1">•</span>
                        <span class="text-gray-500 text-xs"><?= htmlspecialchars($web['label']) ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-400">No websites</div>
        <?php endif; ?>
    </div>
</div>
