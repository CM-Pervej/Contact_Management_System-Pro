<!-- PHONES -->
<div id="notes" class="card bg-gray-200 shadow-md p-3 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Notes</h2>

    <?php foreach ($contact['notes'] ?? [] as $i => $note): ?>
        <div class="flex items-center gap-1 p-3 rounded-lg border note-row">
            <input type="hidden" name="notes[<?= $i ?>][id]" value="<?= $note['id'] ?? '' ?>">

            <!-- Phone: takes remaining space -->
            <input type="text" name="notes[<?= $i ?>][note]" placeholder="Note" 
                value="<?= htmlspecialchars($note['note'] ?? '') ?>" 
                class="border p-1 rounded flex-1 min-w-0"
                title="Notes">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-note" class="btn btn-primary btn-sm mt-2">
        + Add Note
    </button>
</div>

<script>
    // Add Phone
    document.getElementById('add-note')?.addEventListener('click', function(){
        let container = document.getElementById('notes');
        let count = container.querySelectorAll('.note-row').length;
        let div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-3 p-3 rounded-lg border bg-base-200 note-row';
        div.innerHTML = `
            <input type="text" name="notes[${count}][note]" placeholder="Note" class="border p-1 rounded flex-1 min-w-0" title="Notes">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>