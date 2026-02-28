<div class="flex">
    <div class="w-40">🔗 <span class="text-sm text-gray-500 ml-1">Relations</span></div>
    <div class="flex flex-col space-y-2 text-sm">
        <?php if (!empty($contact['relation'])): ?>
                    <span>
                        <?= htmlspecialchars($contact['relation']) ?>
                    </span>
        <?php else: ?>
            <div class="text-gray-400">No Relations</div>
        <?php endif; ?>
    </div>
</div>

<div class="flex">
    <div class="w-40">
        📝 <span class="text-sm text-gray-500 ml-1">Notes</span>
    </div>

    <div class="text-sm">
        <?php if (!empty($contact['notes'])): ?>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach ($contact['notes'] as $n): ?>
                    <li>
                        <?= htmlspecialchars($n['note'], ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-gray-400">No Notes</div>
        <?php endif; ?>
    </div>
</div>
