<div id="addresses" class="card bg-gray-200 shadow-md p-4 sm:p-6">
    <h2 class="mt-4 text-lg font-bold animate-shimmer animate-float">Addresses</h2>

    <?php foreach ($contact['addresses'] ?? [] as $i => $addr): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:flex md:flex-wrap items-center gap-2 mb-3 p-3 rounded-lg border address-row relative">
            <input type="hidden" name="addresses[<?= $i ?>][id]" value="<?= $addr['id'] ?? '' ?>">

            <input type="text" name="addresses[<?= $i ?>][label]" placeholder="Label" title="This is the label for the address"
                value="<?= htmlspecialchars($addr['label'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <input type="text" name="addresses[<?= $i ?>][street]" placeholder="Street" title="Street name or number"
                value="<?= htmlspecialchars($addr['street'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <input type="text" name="addresses[<?= $i ?>][city]" placeholder="City" title="City of residence"
                value="<?= htmlspecialchars($addr['city'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <input type="text" name="addresses[<?= $i ?>][state]" placeholder="State" title="State or province"
                value="<?= htmlspecialchars($addr['state'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <input type="text" name="addresses[<?= $i ?>][postal_code]" placeholder="Postal Code" title="ZIP or postal code"
                value="<?= htmlspecialchars($addr['postal_code'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <input type="text" name="addresses[<?= $i ?>][country]" placeholder="Country" title="Country"
                value="<?= htmlspecialchars($addr['country'] ?? '') ?>"
                class="input input-bordered input-sm w-full sm:w-auto">

            <button type="button" class="delete-btn btn btn-error btn-sm whitespace-nowrap">
                Delete
            </button>
        </div>
    <?php endforeach; ?>

    <button type="button" id="add-address" class="btn btn-primary btn-sm mt-2">
        + Add Address
    </button>
</div>

<script>
    // Add Address
    document.getElementById('add-address')?.addEventListener('click', function(){
        let container = document.getElementById('addresses');
        let count = container.querySelectorAll('.address-row').length;
        let div = document.createElement('div');
        div.className = 'grid grid-cols-2 sm:grid-cols-3 md:flex md:flex-wrap items-center gap-2 mb-3 p-3 rounded-lg address-row relative';
        div.innerHTML = `
            <input type="text" name="addresses[${count}][label]" placeholder="Label" class="input input-bordered input-sm w-full sm:w-auto" title="This is the label for the address">
            <input type="text" name="addresses[${count}][street]" placeholder="Street" class="input input-bordered input-sm w-full sm:w-auto" title="Street name or number">
            <input type="text" name="addresses[${count}][city]" placeholder="City" class="input input-bordered input-sm w-full sm:w-auto" title="City of residence">
            <input type="text" name="addresses[${count}][state]" placeholder="State" class="input input-bordered input-sm w-full sm:w-auto" title="State or province">
            <input type="text" name="addresses[${count}][postal_code]" placeholder="Postal Code" class="input input-bordered input-sm w-full sm:w-auto" title="ZIP or postal code">
            <input type="text" name="addresses[${count}][country]" placeholder="Country" class="input input-bordered input-sm w-full sm:w-auto" title="Country">
            <button type="button" class="delete-btn bg-red-500 text-white px-2 rounded">Delete</button>
        `;
        container.insertBefore(div, this);
    });
</script>