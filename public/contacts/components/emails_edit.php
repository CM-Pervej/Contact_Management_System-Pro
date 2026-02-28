<!-- EMAILS -->
<div id="emails" class="card bg-gray-200 shadow-md p-3 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Emails</h2>

    <?php foreach ($contact['emails'] ?? [] as $i => $email): ?>
        <div class="flex items-center gap-1 p-3 rounded-lg border email-row">
            <input type="hidden" name="emails[<?= $i ?>][id]" value="<?= $email['id'] ?? '' ?>">

            <input type="text" name="emails[<?= $i ?>][label]" placeholder="Label" 
                value="<?= htmlspecialchars($email['label'] ?? '') ?>" 
                class="border p-1 rounded flex-none max-w-[100px]"
                title="Email label (e.g., Work, Personal)">

            <input type="email" name="emails[<?= $i ?>][email]" placeholder="Email" 
                value="<?= htmlspecialchars($email['email'] ?? '') ?>" 
                class="border p-1 rounded flex-1 min-w-0"
                title="Email address">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-email" class="btn btn-primary btn-sm mt-2">
        + Add Email
    </button>
</div>

<script>
    // Add Email
    document.getElementById('add-email')?.addEventListener('click', function(){
        let container = document.getElementById('emails');
        let count = container.querySelectorAll('.email-row').length;
        let div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-3 p-3 rounded-lg border bg-base-200 email-row space-x-2';
        div.innerHTML = `
            <input type="text" name="emails[${count}][label]" placeholder="Label" class="border p-1 rounded flex-none max-w-[100px]">
            <input type="email" name="emails[${count}][email]" placeholder="Email" class="border p-1 rounded flex-1 min-w-0">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>