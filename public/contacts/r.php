<?php
    // session_start();
    require_once "../../vendor/autoload.php";
    require_once __DIR__ . '/../layout/layout.php';

    use App\Controllers\ContactController;

    $controller = new ContactController();
    $errors = [];
    $success = "";

    // If form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Upload images
        $images = [];

        if (!empty($_FILES['front_image']['name'])) {
            $path = "../../uploads/" . time() . "_front_" . basename($_FILES['front_image']['name']);
            move_uploaded_file($_FILES['front_image']['tmp_name'], $path);
            $images[] = ["type" => "front", "file_path" => $path];
        }

        if (!empty($_FILES['back_image']['name'])) {
            $path = "../../uploads/" . time() . "_back_" . basename($_FILES['back_image']['name']);
            move_uploaded_file($_FILES['back_image']['tmp_name'], $path);
            $images[] = ["type" => "back", "file_path" => $path];
        }

        // Prepare full data array
        $data = [
            "user_id"       => $_SESSION['user']['id'],
            "first_name"    => $_POST['first_name'] ?? "",
            "middle_name"   => $_POST['middle_name'] ?? "",
            "last_name"     => $_POST['last_name'] ?? "",
            "nickname"      => $_POST['nickname'] ?? "",
            "phonetic_first"=> $_POST['phonetic_first'] ?? "",
            "phonetic_last" => $_POST['phonetic_last'] ?? "",
            "name_suffix"   => $_POST['name_suffix'] ?? "",
            "name_prefix"   => $_POST['name_prefix'] ?? "",
            "company"       => $_POST['company'] ?? "",
            "department"    => $_POST['department'] ?? "",
            "title"         => $_POST['title'] ?? "",
            "notes"         => $_POST['notes'] ?? "",
            "relation"      => $_POST['relation'] ?? "",

            // multiple fields
            "phones"     => $_POST['phones'] ?? [],
            "emails"     => $_POST['emails'] ?? [],
            "dates"      => $_POST['dates'] ?? [],
            "addresses"  => $_POST['addresses'] ?? [],
            "websites"   => $_POST['websites'] ?? [],
            "images"     => $images
        ];

        // Call controller
        $result = $controller->store($data);

        if ($result) {
            $success = $controller->success;
        } else {
            $errors = $controller->errors;
        }
    }
?>

<section>
    <h2 class="text-2xl font-bold">Create New Contact</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="color:green;"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <!-- Basic info -->
        <h3 class="text-lg font-semibold">Name</h3>
        <div class="grid grid-cols-3 gap-5">
            <input type="text" name="first_name" placeholder="First Name">
            <input type="text" name="middle_name" placeholder="Middle Name">
            <input type="text" name="last_name" placeholder="Last Name">
            <input type="text" name="nickname" placeholder="Nickname">
            <input type="text" name="phonetic_first" placeholder="Phonetic First">
            <input type="text" name="phonetic_last" placeholder="Phonetic Last">
            <input type="text" name="name_prefix" placeholder="Prefix (Mr, Dr...)">
            <input type="text" name="name_suffix" placeholder="Suffix (Jr, Sr...)">
        </div>

        <!-- Work Info -->
        <h3>Work Info</h3>
        <div class="grid grid-cols-3 gap-5">
            <input type="text" name="company" placeholder="Company">
            <input type="text" name="department" placeholder="Department">
            <input type="text" name="title" placeholder="Job Title">
        </div>

        <!-- Phones -->
        <h3>Phone Numbers</h3>
        <div class="flex gap-5" id="phones_block">
            <div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="phones[0][label]" placeholder="Label">
                <input type="text" name="phones[0][phone]" placeholder="Phone Number">
            </div>
            <span class="add-btn whitespace-nowrap cursor-pointer" onclick="addPhone()">+ Add Phone</span>
        </div>

        <!-- Emails -->
        <h3>Email Addresses</h3>
        <div class="flex gap-5" id="emails_block">
            <div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="emails[0][label]" placeholder="Label">
                <input type="email" name="emails[0][email]" placeholder="Email">
            </div>
            <span class="add-btn whitespace-nowrap cursor-pointer" onclick="addEmail()">+ Add Email</span>
        </div>

        <!-- Dates -->
        <h3>Important Dates</h3>
        <div class="flex gap-5" id="dates_block">
            <div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="dates[0][label]" placeholder="Label">
                <input type="date" name="dates[0][date]">
            </div>
            <span class="add-btn whitespace-nowrap cursor-pointer" onclick="addDate()">+ Add Date</span>
        </div>

        <!-- Addresses -->
        <h3>Addresses</h3>
        <div class="flex gap-5 items-center" id="addresses_block">
            <div class="grid grid-cols-3 gap-5 w-full">
                <input type="text" name="addresses[0][label]" placeholder="Label">
                <input type="text" name="addresses[0][street]" placeholder="Street">
                <input type="text" name="addresses[0][city]" placeholder="City">
                <input type="text" name="addresses[0][state]" placeholder="State">
                <input type="text" name="addresses[0][postal_code]" placeholder="Postal Code">
                <input type="text" name="addresses[0][country]" placeholder="Country">
            </div>
            <span class="add-btn whitespace-nowrap cursor-pointer" onclick="addAddress()">+ Add Address</span>
        </div>

        <!-- Websites -->
        <h3>Websites</h3>
        <div class="flex gap-5 items-center" id="websites_block">
            <div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="websites[0][label]" placeholder="Label">
                <input type="text" name="websites[0][url]" placeholder="URL">
            </div>
            <span class="add-btn whitespace-nowrap cursor-pointer" onclick="addWebsite()">+ Add Website</span>
        </div>

        <!-- Images -->
        <h3>Contact Images</h3>
        <div class="block">
            Front Image: <input type="file" name="front_image"><br><br>
            Back Image: <input type="file" name="back_image"><br>
        </div>

        <!-- Notes -->
        <h3>Other Info</h3>
        <div class="w-full">
            <textarea name="notes" placeholder="Notes" class="w-full"></textarea><br>
            <input type="text" name="relation" placeholder="Relation (friend, sister etc)">
        </div>

        <button type="submit">Create Contact</button>

    </form>
</section>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>

<script>
    let phoneIndex = 1;
    function addPhone() {
        document.getElementById('phones_block').innerHTML +=
            `<div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="phones[${phoneIndex}][label]" placeholder="Label">
                <input type="text" name="phones[${phoneIndex}][phone]" placeholder="Phone">
            </div>`;
        phoneIndex++;
    }

    let emailIndex = 1;
    function addEmail() {
        document.getElementById('emails_block').innerHTML +=
            `<div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="emails[${emailIndex}][label]" placeholder="Label">
                <input type="email" name="emails[${emailIndex}][email]" placeholder="Email">
            </div>`;
        emailIndex++;
    }

    let dateIndex = 1;
    function addDate() {
        document.getElementById('dates_block').innerHTML +=
            `<div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="dates[${dateIndex}][label]" placeholder="Label">
                <input type="date" name="dates[${dateIndex}][date]">
            </div>`;
        dateIndex++;
    }

    let addressIndex = 1;
    function addAddress() {
        document.getElementById('addresses_block').innerHTML +=
            `<div class="grid grid-cols-3 gap-5 w-full">
                <input type="text" name="addresses[${addressIndex}][label]" placeholder="Label">
                <input type="text" name="addresses[${addressIndex}][street]" placeholder="Street">
                <input type="text" name="addresses[${addressIndex}][city]" placeholder="City">
                <input type="text" name="addresses[${addressIndex}][state]" placeholder="State">
                <input type="text" name="addresses[${addressIndex}][postal_code]" placeholder="Postal Code">
                <input type="text" name="addresses[${addressIndex}][country]" placeholder="Country">
            </div>`;
        addressIndex++;
    }

    let websiteIndex = 1;
    function addWebsite() {
        document.getElementById('websites_block').innerHTML +=
            `<div class="grid grid-cols-2 gap-5 w-full">
                <input type="text" name="websites[${websiteIndex}][label]" placeholder="Label">
                <input type="text" name="websites[${websiteIndex}][url]" placeholder="URL">
            </div>`;
        websiteIndex++;
    }
</script>