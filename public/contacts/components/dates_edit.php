<!-- DATES -->
<div id="dates" class="card bg-gray-200 shadow-md p-4 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Dates</h2>

    <?php foreach ($contact['dates'] ?? [] as $i => $date): ?>
        <div class="flex items-center gap-1 p-3 rounded-lg border date-row">
            <input type="hidden" name="dates[<?= $i ?>][id]" value="<?= $date['id'] ?? '' ?>">

            <input type="text" name="dates[<?= $i ?>][label]" placeholder="Label" 
                value="<?= htmlspecialchars($date['label'] ?? '') ?>" 
                class="border p-1 rounded flex-none [w-auto] max-w-[100px]"
                title="Date label (e.g., Birthday, Anniversary)">

            <input type="date" name="dates[<?= $i ?>][date]" 
                value="<?= htmlspecialchars($date['date'] ?? '') ?>" 
                class="border p-1 rounded flex-1 min-w-0"
                title="Select a date">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-date" class="btn btn-primary btn-sm mt-2">
        + Add Date
    </button>
</div>

<script>
    // Add Date
    document.getElementById('add-date')?.addEventListener('click', function(){
        let container = document.getElementById('dates');
        let count = container.querySelectorAll('.date-row').length;
        let div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-3 p-3 rounded-lg border bg-base-200 date-row';
        div.innerHTML = `
            <input type="text" name="dates[${count}][label]" placeholder="Label" class="border p-1 rounded flex-none [w-auto]  max-w-[100px]">
            <input type="date" name="dates[${count}][date]" class="border p-1 rounded flex-1 min-w-0">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>