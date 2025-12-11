<!-- Horizontal container: sidebar + main content -->
<div class="flex flex-1">
  <div class="flex-1 flex flex-col lg:ml-64">
    <!-- Topbar -->
    <div class="navbar bg-base-100 shadow-md px-4">
      <!-- Mobile menu button -->
      <button id="sidebar-toggle" class="btn btn-square btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <div class="flex-1">
        <a class="text-xl font-bold">Contact Management System -Pro</a>
      </div>

      <div class="flex-none">
        <div class="dropdown dropdown-end">
            <div class="flex justify-center items-center gap-2">
                <div class="right">
                    <?php if(isset($_SESSION['user'])): ?>
                        <span><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                    <?php endif; ?>
                </div>
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                    <img alt="User" src="https://i.pravatar.cc/100" />
                    </div>
                </label>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                <li><a>Profile</a></li>
                <li><a>Settings</a></li>
                <li><a href="/contact/public/logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
      </div>
    </div>

    <!-- Main content container -->
    <div class="p-6 space-y-6 flex-1 overflow-auto">
