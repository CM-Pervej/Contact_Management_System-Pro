<!-- WEBSITES -->
<div id="websites" class="card bg-gray-200 shadow-md p-3 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Websites</h2>

    <?php foreach ($contact['websites'] ?? [] as $i => $web): ?>
        <div class="flex items-center gap-1 p-3 rounded-lg border website-row">
            <input type="hidden" name="websites[<?= $i ?>][id]" value="<?= $web['id'] ?? '' ?>">

            <input type="text" name="websites[<?= $i ?>][label]" placeholder="Label" 
                value="<?= htmlspecialchars($web['label'] ?? '') ?>" 
                class="border p-1 rounded flex-none [w-auto] max-w-[100px]"
                title="Website label (e.g., Portfolio, Company)">

            <input type="text" name="websites[<?= $i ?>][url]" placeholder="URL" 
                value="<?= htmlspecialchars($web['url'] ?? '') ?>" required
                class="border p-1 rounded flex-1 min-w-0"
                title="Enter the website URL">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-website" class="btn btn-primary btn-sm mt-2">
        + Add Website
    </button>
</div>

<script>
    // Add Website
    document.getElementById('add-website')?.addEventListener('click', function(){
        let container = document.getElementById('websites');
        let count = container.querySelectorAll('.website-row').length;
        let div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-3 p-3 rounded-lg border bg-base-200 website-row';
        div.innerHTML = `
            <input type="text" name="websites[${count}][label]" placeholder="Label" class="border p-1 rounded flex-none [w-auto]  max-w-[100px]">
            <input type="text" name="websites[${count}][url]" placeholder="URL" class="border p-1 rounded flex-1 min-w-0">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>