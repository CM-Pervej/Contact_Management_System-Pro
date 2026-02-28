<div id="images" class="mt-6">
    <h2 class="mt-4 mb-2 text-lg font-bold animate-shimmer animate-float">Images</h2>

    <?php
    $front = $back = null;

    foreach ($contact['images'] ?? [] as $img) {
        if ($img['type'] === 'front') $front = $img;
        if ($img['type'] === 'back')  $back  = $img;
    }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        <!-- FRONT IMAGE -->
        <div class="border rounded p-3">
            <p class="font-medium mb-2">Front Image</p>

            <img
                id="frontPreview"
                src="<?= $front
                    ? '/contact/' . htmlspecialchars($front['file_path'])
                    : '/contact/assets/no-image.png' ?>"
                class="w-full h-96 object-cover rounded mb-2 border">

            <input
                type="file"
                name="front_image"
                id="frontInput"
                accept="image/*">

            <p class="text-xs text-gray-500 mt-1">
                Selecting a new image will replace the old one
            </p>
        </div>

        <!-- BACK IMAGE -->
        <div class="border rounded p-3">
            <p class="font-medium mb-2">Back Image</p>

            <img
                id="backPreview"
                src="<?= $back
                    ? '/contact/' . htmlspecialchars($back['file_path'])
                    : '/contact/assets/no-image.png' ?>"
                class="w-full h-96 object-cover rounded mb-2 border">

            <input type="file" name="back_image" id="backInput" accept="image/*">

            <p class="text-xs text-gray-500 mt-1"> Selecting a new image will replace the old one </p>
        </div>
    </div>
</div>

<script>
function bindImagePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (!input || !preview) return;

    input.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
}

bindImagePreview('frontInput', 'frontPreview');
bindImagePreview('backInput', 'backPreview');
</script>