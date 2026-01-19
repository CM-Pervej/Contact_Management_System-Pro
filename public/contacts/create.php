<?php
    require_once "../../vendor/autoload.php";
    require_once __DIR__ . '/../layout/layout.php';

    use App\Controllers\ContactController;

    $controller = new ContactController();
    $errors = [];
    $success = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $uploadDir = realpath(__DIR__ . '/../../') . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $images = [];

        /* FRONT IMAGE */
        if (!empty($_FILES['front_image']['name'])) {
            $filename = time() . '_front_' . basename($_FILES['front_image']['name']);
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['front_image']['tmp_name'], $targetPath)) {
                $errors[] = "Front image upload failed";
            } else {
                $images[] = [
                    "type" => "front",
                    "file_path" => "uploads/" . $filename // DB / public path
                ];
            }
        }

        /* BACK IMAGE */
        if (!empty($_FILES['back_image']['name'])) {
            $filename = time() . '_back_' . basename($_FILES['back_image']['name']);
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['back_image']['tmp_name'], $targetPath)) {
                $errors[] = "Back image upload failed";
            } else {
                $images[] = [
                    "type" => "back",
                    "file_path" => "uploads/" . $filename
                ];
            }
        }

        $data = [
            "user_id"        => $_SESSION['user']['id'],
            "first_name"     => $_POST['first_name'] ?? "",
            "middle_name"    => $_POST['middle_name'] ?? "",
            "last_name"      => $_POST['last_name'] ?? "",
            "nickname"       => $_POST['nickname'] ?? "",
            "phonetic_first" => $_POST['phonetic_first'] ?? "",
            "phonetic_last"  => $_POST['phonetic_last'] ?? "",
            "name_prefix"    => $_POST['name_prefix'] ?? "",
            "name_suffix"    => $_POST['name_suffix'] ?? "",
            "company"        => $_POST['company'] ?? "",
            "department"     => $_POST['department'] ?? "",
            "title"          => $_POST['title'] ?? "",
            "notes"          => $_POST['notes'] ?? "",
            "relation"       => $_POST['relation'] ?? "",
            "phones"         => $_POST['phones'] ?? [],
            "emails"         => $_POST['emails'] ?? [],
            "dates"          => $_POST['dates'] ?? [],
            "addresses"      => $_POST['addresses'] ?? [],
            "websites"       => $_POST['websites'] ?? [],
            "images"         => $images
        ];

        $result = $controller->store($data);
        $result ? $success = $controller->success : $errors = $controller->errors;
    }
?>

<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-xl mt-6">
    <!-- STEPPER -->
    <div class="flex items-center justify-between mb-10">
        <?php for ($i=1;$i<=4;$i++): ?>
        <div id="step<?= $i ?>Indicator"
            class="step-upcoming w-10 h-10 flex items-center justify-center rounded-full border font-semibold">
            <?= $i ?>
        </div>
        <?php if ($i<4): ?><div class="flex-1 h-1 bg-gray-300 mx-2"></div><?php endif; ?>
        <?php endfor; ?>
    </div>

    <?php if ($errors): ?>
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- STEP 1 -->
        <div id="step1" class="step-section">
            <h2 class="text-xl font-bold mb-4">Name & Phonetic</h2>
            <div class="grid grid-cols-3 gap-4">
                <input name="first_name" class="input input-bordered" placeholder="First Name" required>
                <input name="middle_name" class="input input-bordered" placeholder="Middle Name">
                <input name="last_name" class="input input-bordered" placeholder="Last Name">
                <input name="nickname" class="input input-bordered" placeholder="Nickname">
                <input name="phonetic_first" class="input input-bordered" placeholder="Phonetic First">
                <input name="phonetic_last" class="input input-bordered" placeholder="Phonetic Last">
                <input name="name_prefix" class="input input-bordered" placeholder="Prefix">
                <input name="name_suffix" class="input input-bordered" placeholder="Suffix">
            </div>
            <div class="text-right mt-6">
                <button type="button" class="btn btn-primary" onclick="goStep(2)">Next</button>
            </div>
        </div>

        <!-- STEP 2 -->
        <div id="step2" class="step-section hidden">
            <h2 class="text-xl font-bold mb-4">Work / Phones / Emails</h2>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <input name="company" class="input input-bordered" placeholder="Company">
                <input name="department" class="input input-bordered" placeholder="Department">
                <input name="title" class="input input-bordered" placeholder="Job Title">
            </div>

            <h3 class="font-semibold">Phones</h3>
            <div id="phones_block"></div>
            <button type="button" class="btn btn-sm mt-2" onclick="addPhone()">+ Add Phone</button>

            <h3 class="font-semibold mt-6">Emails</h3>
            <div id="emails_block"></div>
            <button type="button" class="btn btn-sm mt-2" onclick="addEmail()">+ Add Email</button>

            <div class="flex justify-between mt-6">
                <button type="button" class="btn" onclick="goStep(1)">Back</button>
                <button type="button" class="btn btn-primary" onclick="goStep(3)">Next</button>
            </div>
        </div>

        <!-- STEP 3 -->
        <div id="step3" class="step-section hidden">
            <h2 class="text-xl font-bold mb-4">Dates / Addresses / Websites</h2>

            <h3 class="font-semibold">Dates</h3>
            <div id="dates_block"></div>
            <button type="button" class="btn btn-sm mt-2" onclick="addDate()">+ Add Date</button>

            <h3 class="font-semibold mt-6">Addresses</h3>
            <div id="addresses_block"></div>
            <button type="button" class="btn btn-sm mt-2" onclick="addAddress()">+ Add Address</button>

            <h3 class="font-semibold mt-6">Websites</h3>
            <div id="websites_block"></div>
            <button type="button" class="btn btn-sm mt-2" onclick="addWebsite()">+ Add Website</button>

            <div class="flex justify-between mt-6">
                <button type="button" class="btn" onclick="goStep(2)">Back</button>
                <button type="button" class="btn btn-primary" onclick="goStep(4)">Next</button>
            </div>
        </div>

        <!-- STEP 4 -->
        <div id="step4" class="step-section hidden">
            <h2 class="text-xl font-bold mb-4">Images & Notes</h2>

            <label>Front Image</label>
            <input type="file" accept="image/*" name="front_image" class="file-input file-input-bordered w-full mb-4" onchange="previewImage(event,'previewFront')">

            <div class="flex justify-between">
                <img id="previewFront" class="mt-3 w-32 rounded-xl hidden">
                <img id="previewBack" class="mt-3 w-32 rounded-xl hidden">
            </div>

            <label>Back Image</label>
            <input type="file" accept="image/*" name="back_image" class="file-input file-input-bordered w-full mb-4" onchange="previewImage(event,'previewBack')">

            <textarea name="notes" class="textarea textarea-bordered w-full mb-3" placeholder="Notes"></textarea>
            <input name="relation" class="input input-bordered w-full" placeholder="Relation">

            <div class="flex justify-between mt-6">
                <button type="button" class="btn" onclick="goStep(3)">Back</button>
                <button class="btn btn-success">Create Contact</button>
            </div>
        </div>
    </form>
</div>

<style>
    .step-active{background:#2563eb;color:#fff;border-color:#2563eb}
    .step-done{background:#22c55e;color:#fff;border-color:#22c55e}
    .step-upcoming{background:#e5e7eb;color:#374151}
    .hidden{display:none}
</style>

<script>
    let current = 1;

    function goStep(step) {

        // ✅ validate current step before going forward
        if (step > current) {
            const currentStep = document.getElementById('step' + current);
            const inputs = currentStep.querySelectorAll('input, textarea, select');

            for (let input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return; // ❌ stop going next
                }
            }
        }

        // switch steps
        document.querySelectorAll('.step-section')
            .forEach(s => s.classList.add('hidden'));

        document.getElementById('step' + step)
            .classList.remove('hidden');

        // update indicators
        for (let i = 1; i <= 4; i++) {
            let el = document.getElementById('step' + i + 'Indicator');
            el.classList.remove('step-active', 'step-done', 'step-upcoming');
            el.classList.add(
                i < step ? 'step-done' :
                i === step ? 'step-active' :
                'step-upcoming'
            );
        }

        current = step;
    }

    /* dynamic fields */
    let p=0,e=0,d=0,a=0,w=0;
    const addPhone=()=>phones_block.insertAdjacentHTML('beforeend',
        `<div class="grid grid-cols-2 gap-4 mb-2">
            <input name="phones[${p}][label]" class="input input-bordered" placeholder="Label">
            <input name="phones[${p++}][phone]" class="input input-bordered" placeholder="Phone"  ${p === 1 ? 'required' : ''}>
        </div>`);

    const addEmail=()=>emails_block.insertAdjacentHTML('beforeend',
        `<div class="grid grid-cols-2 gap-4 mb-2">
            <input name="emails[${e}][label]" class="input input-bordered" placeholder="Label">
            <input name="emails[${e++}][email]" class="input input-bordered" placeholder="Email">
        </div>`);

    const addDate=()=>dates_block.insertAdjacentHTML('beforeend',
        `<div class="grid grid-cols-2 gap-4 mb-2">
            <input name="dates[${d}][label]" class="input input-bordered" placeholder="Label">
            <input type="date" name="dates[${d++}][date]" class="input input-bordered">
        </div>`);

    const addAddress=()=>addresses_block.insertAdjacentHTML('beforeend',
        `<div class="grid grid-cols-3 gap-4 mb-2">
            <input name="addresses[${a}][label]" class="input input-bordered" placeholder="Label">
            <input name="addresses[${a}][street]" class="input input-bordered" placeholder="Street">
            <input name="addresses[${a}][city]" class="input input-bordered" placeholder="City">
            <input name="addresses[${a}][state]" class="input input-bordered" placeholder="State">
            <input name="addresses[${a}][postal_code]" class="input input-bordered" placeholder="Postal Code">
            <input name="addresses[${a++}][country]" class="input input-bordered" placeholder="Country">
        </div>`);

    const addWebsite=()=>websites_block.insertAdjacentHTML('beforeend',
        `<div class="grid grid-cols-2 gap-4 mb-2">
            <input name="websites[${w}][label]" class="input input-bordered" placeholder="Label">
            <input name="websites[${w++}][url]" class="input input-bordered" placeholder="URL">
        </div>`);

    /* IMAGE PREVIEW */
    function previewImage(event, id) {
        const img = document.getElementById(id);
        img.src = URL.createObjectURL(event.target.files[0]);
        img.classList.remove("hidden");
    }

    /* init */
    addPhone(); 
    addEmail(); 
    addDate(); 
    addAddress(); 
    addWebsite();
    goStep(1);
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
