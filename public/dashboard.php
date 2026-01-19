<?php
    $pageTitle = "CMS-Pro/Dashboard";
    require_once 'layout/layout.php';
?>

<!-- Stats Cards -->
<div class="grid gap-6 md:grid-cols-3">
  <div class="stat bg-base-100 shadow rounded-xl">
    <div class="stat-title">Total Contacts</div>
    <div class="stat-value">1,250</div>
    <div class="stat-desc">+10% this month</div>
  </div>

  <div class="stat bg-base-100 shadow rounded-xl">
    <div class="stat-title">New Contacts</div>
    <div class="stat-value">58</div>
    <div class="stat-desc">+5% this week</div>
  </div>

  <div class="stat bg-base-100 shadow rounded-xl">
    <div class="stat-title">Trash</div>
    <div class="stat-value">34</div>
    <div class="stat-desc">Recently deleted</div>
  </div>
</div>

<!-- Contacts Table -->
<div class="bg-base-100 rounded-xl shadow p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Recent Contacts</h2>
    <button class="btn btn-primary"><a href="/contact/public/contacts/create.php">+ Add New Contact</a></button>
  </div>

  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>john@example.com</td>
          <td>+880123456789</td>
          <td>
            <button class="btn btn-xs btn-info">Edit</button>
            <button class="btn btn-xs btn-error">Delete</button>
          </td>
        </tr>
        <tr>
          <td>Sarah Smith</td>
          <td>sarah@example.com</td>
          <td>+880987654321</td>
          <td>
            <button class="btn btn-xs btn-info">Edit</button>
            <button class="btn btn-xs btn-error">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php require_once 'layout/footer.php'; ?>