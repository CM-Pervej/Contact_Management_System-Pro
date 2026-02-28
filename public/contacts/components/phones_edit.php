<!-- PHONES -->
<div id="phones" class="card bg-gray-200 shadow-md p-3 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Phones</h2>

    <?php foreach ($contact['phones'] ?? [] as $i => $phone): ?>
        <div class="flex items-center gap-1 p-3 rounded-lg border phone-row">
            <input type="hidden" name="phones[<?= $i ?>][id]" value="<?= $phone['id'] ?? '' ?>">

            <!-- Label: only takes max content width -->
            <input type="text" name="phones[<?= $i ?>][label]" placeholder="Label" 
                value="<?= htmlspecialchars($phone['label'] ?? '') ?>" 
                class="border p-1 rounded flex-none [w-auto] max-w-[100px]"
                title="Phone label (e.g., Mobile, Home, Work)">

            <!-- Phone: takes remaining space -->
            <input type="text" name="phones[<?= $i ?>][phone]" placeholder="Phone" 
                value="<?= htmlspecialchars($phone['phone'] ?? '') ?>" 
                class="border p-1 rounded flex-1 min-w-0"
                title="Phone number">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-phone" class="btn btn-primary btn-sm mt-2">
        + Add Phone
    </button>
</div>

<script>
    // Add Phone
    document.getElementById('add-phone')?.addEventListener('click', function(){
        let container = document.getElementById('phones');
        let count = container.querySelectorAll('.phone-row').length;
        let div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-3 p-3 rounded-lg border bg-base-200 phone-row';
        div.innerHTML = `
            <input type="text" name="phones[${count}][label]" placeholder="Label" class="border p-1 rounded flex-none [w-auto]  max-w-[100px]" title="Phone label (e.g., Mobile, Home, Work)">
            <input type="text" name="phones[${count}][phone]" placeholder="Phone" class="border p-1 rounded flex-1 min-w-0" title="Phone number">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>