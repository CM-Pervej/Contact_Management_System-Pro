<?php
  require_once "../../vendor/autoload.php";
  $pageTitle = "ContactMS-Pro/Manage Relations";
  require_once __DIR__ . '/../layout/layout.php';

  use App\Controllers\RelationshipController;

  $controller = new RelationshipController();
  $controller->index();

  $errors    = $controller->errors;
  $success   = $controller->success;
  $relations = $controller->relations;
  $delete_id = $controller->delete_id;

  // Check editing
  $edit_id = !empty($_GET['edit_id']) ? (int)$_GET['edit_id'] : null;
  $edit_rel_name = '';
  if ($edit_id && empty($success)) {
      foreach ($relations as $r) {
          if ($r['id'] == $edit_id) {
              $edit_rel_name = $r['rel_name'];
              break;
          }
      }
  }
?>

<section class="mx-auto p-8">
  <h1 class="text-2xl font-bold mb-4">Manage Relationships</h1>

  <!-- Errors -->
  <?php if (!empty($errors)): ?>
      <?php foreach($errors as $error): ?>
          <div class="bg-red-100 text-red-800 p-2 rounded mb-2"><?= $error ?></div>
      <?php endforeach; ?>
  <?php endif; ?>

  <!-- Add/Update Form -->
  <form method="POST" class="flex mb-6" autocomplete="off">
    <input type="hidden" name="rel_id" value="<?= $edit_id ?? '' ?>">
    <input type="text" name="rel_name" placeholder="Relation Name" class="flex-1 border rounded p-2 mr-2" value="<?= htmlspecialchars($edit_rel_name) ?>" required>
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        <?= $edit_id ? 'Update' : 'Add' ?>
    </button>
  </form>

  <!-- Relations Table -->
  <table class="w-full table-auto border-collapse border border-gray-300">
    <thead>
      <tr class="bg-gray-200 text-center">
        <th class="border border-gray-300 px-4 py-2">SL.</th>
        <th class="border border-gray-300 px-4 py-2">Relation Name</th>
        <th class="border border-gray-300 px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($relations)): ?>
          <?php foreach($relations as $index => $rel): ?>
              <tr class="text-center">
                  <td class="border border-gray-300 px-4 py-2"><?= $index + 1 ?></td>
                  <td class="border border-gray-300 px-4 py-2 font-semibold text-gray-700"><?= $rel['rel_name'] ?></td>
                  <td class="border border-gray-300 px-4 py-2">
                      <a href="?edit_id=<?= $rel['id'] ?>" class="text-blue-600 hover:underline mr-2">Edit</a>
                      <a href="?delete_id=<?= $rel['id'] ?>" class="text-red-600 hover:underline">Delete</a>
                  </td>
              </tr>
          <?php endforeach; ?>
      <?php else: ?>
          <tr>
              <td colspan="3" class="text-center p-4">No relations found</td>
          </tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>

<!-- Delete Confirmation Modal -->
<?php if ($delete_id): ?>
<input type="checkbox" id="delete-modal" class="modal-toggle" checked />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Delete</h3>
    <p class="py-4">Are you sure you want to delete this relation?</p>
    <div class="modal-action">
      <form method="POST">
        <input type="hidden" name="confirm_delete_id" value="<?= $delete_id ?>">
        <button type="submit" class="btn btn-error">Delete</button>
      </form>
      <a href="index.php" class="btn">Cancel</a>
    </div>
  </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>