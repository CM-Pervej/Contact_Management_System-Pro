<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/contact/uploads/logo.png" type="image/png">
  <title>Contact Management System Pro</title>

  <!-- Tailwind + DaisyUI -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-base-100 text-base-content">

<!-- ================= NAVBAR ================= -->
<header class="navbar fixed top-0 z-50 bg-base-100 border-b border-base-300 px-6 lg:px-14">
  <div class="navbar-start">
    <div class="dropdown lg:hidden">
      <label tabindex="0" class="btn btn-ghost">☰</label>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-3 shadow bg-base-100 rounded-box w-60">
        <li><a>Product</a></li>
        <li><a>Solutions</a></li>
        <li><a>Security</a></li>
        <li><a>Pricing</a></li>
        <li><a>Docs</a></li>
      </ul>
    </div>
    <span class="text-xl font-semibold">
      ContactMS<span class="text-primary">Pro</span>
    </span>
  </div>

  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal gap-8">
      <li><a>Product</a></li>
      <li><a>Solutions</a></li>
      <li><a>Security</a></li>
      <li><a>Pricing</a></li>
      <li><a class="font-medium">Docs</a></li>
    </ul>
  </div>

  <div class="navbar-end gap-3">
    <a class="btn btn-outline btn-sm" href="public/dashboard.php">Sign in</a>
    <a class="btn btn-primary btn-sm" href="public/register.php">Get Started</a>
  </div>
</header>

<div class="h-20"></div>

<!-- ================= HERO ================= -->
<section class="max-w-screen-2xl mx-auto px-6 lg:px-14 py-28">
  <div class="grid lg:grid-cols-12 gap-16 items-center">

    <div class="lg:col-span-7">
      <h1 class="text-5xl xl:text-6xl font-bold leading-tight">
        A Modern Contact Management Platform  
        Built for <span class="text-primary">Growing Organizations</span>
      </h1>

      <p class="mt-8 text-lg text-base-content/70 max-w-3xl">
        Contact Management System Pro helps businesses centralize contact data,
        streamline collaboration, and maintain secure customer relationships
        across teams and departments.
      </p>

      <div class="mt-10 flex flex-wrap gap-4">
        <button class="btn btn-primary btn-lg">Start Free Trial</button>
        <button class="btn btn-outline btn-lg">Request Demo</button>
        <button class="btn btn-ghost btn-lg">Read Documentation</button>
      </div>

      <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm text-base-content/60">
        <span>✔ No credit card required</span>
        <span>✔ GDPR compliant</span>
        <span>✔ Enterprise ready</span>
        <span>✔ Secure cloud hosting</span>
      </div>
    </div>

    <!-- Side Overview -->
    <div class="lg:col-span-5">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card bg-base-200">
          <div class="card-body">
            <h3 class="font-semibold">Centralized Contacts</h3>
            <p class="text-base-content/70">
              Keep all business contacts in one unified system.
            </p>
          </div>
        </div>
        <div class="card bg-base-200">
          <div class="card-body">
            <h3 class="font-semibold">Advanced Search</h3>
            <p class="text-base-content/70">
              Find contacts instantly using smart filters.
            </p>
          </div>
        </div>
        <div class="card bg-base-200">
          <div class="card-body">
            <h3 class="font-semibold">Team Collaboration</h3>
            <p class="text-base-content/70">
              Share contact insights across departments.
            </p>
          </div>
        </div>
        <div class="card bg-base-200">
          <div class="card-body">
            <h3 class="font-semibold">Access Control</h3>
            <p class="text-base-content/70">
              Role-based permissions for secure access.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ================= USE CASES ================= -->
<section class="bg-base-200 py-24">
  <div class="max-w-screen-2xl mx-auto px-6 lg:px-14">
    <h2 class="text-4xl font-bold mb-14">
      Designed for Every Team
    </h2>

    <div class="grid md:grid-cols-3 gap-10">
      <div class="card bg-base-100">
        <div class="card-body">
          <h3 class="text-xl font-semibold">Sales Teams</h3>
          <p class="text-base-content/70">
            Track leads, prospects, and customers in one place.
          </p>
        </div>
      </div>
      <div class="card bg-base-100">
        <div class="card-body">
          <h3 class="text-xl font-semibold">Support Teams</h3>
          <p class="text-base-content/70">
            Access customer history to resolve issues faster.
          </p>
        </div>
      </div>
      <div class="card bg-base-100">
        <div class="card-body">
          <h3 class="text-xl font-semibold">Operations</h3>
          <p class="text-base-content/70">
            Maintain accurate internal and external directories.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= STATS ================= -->
<section class="py-20">
  <div class="max-w-screen-2xl mx-auto px-6 lg:px-14 grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
    <div>
      <h3 class="text-4xl font-bold text-primary">25K+</h3>
      <p class="text-base-content/70">Organizations</p>
    </div>
    <div>
      <h3 class="text-4xl font-bold text-primary">99.99%</h3>
      <p class="text-base-content/70">System Uptime</p>
    </div>
    <div>
      <h3 class="text-4xl font-bold text-primary">80M+</h3>
      <p class="text-base-content/70">Contacts Stored</p>
    </div>
    <div>
      <h3 class="text-4xl font-bold text-primary">24/7</h3>
      <p class="text-base-content/70">Enterprise Support</p>
    </div>
  </div>
</section>

<!-- ================= FINAL CTA ================= -->
<section class="bg-base-200 py-24">
  <div class="max-w-6xl mx-auto text-center px-6">
    <h2 class="text-4xl font-bold mb-6">
      Ready to Modernize Your Contact Management?
    </h2>
    <p class="text-lg text-base-content/70 mb-10">
      Start organizing your contacts with clarity, security, and confidence.
    </p>
    <div class="flex justify-center gap-4 flex-wrap">
      <button class="btn btn-primary btn-lg">Get Started Free</button>
      <button class="btn btn-outline btn-lg">Talk to Sales</button>
    </div>
  </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="border-t border-base-300 py-12">
  <div class="max-w-screen-2xl mx-auto px-6 lg:px-14 grid md:grid-cols-4 gap-10 text-sm text-base-content/70">
    <div>
      <p class="font-semibold mb-2">ContactMS Pro</p>
      <p>Professional contact management platform for modern businesses.</p>
    </div>
    <div>
      <p class="font-semibold mb-2">Product</p>
      <ul class="space-y-1">
        <li><a class="link link-hover">Features</a></li>
        <li><a class="link link-hover">Security</a></li>
        <li><a class="link link-hover">Pricing</a></li>
      </ul>
    </div>
    <div>
      <p class="font-semibold mb-2">Resources</p>
      <ul class="space-y-1">
        <li><a class="link link-hover">Docs</a></li>
        <li><a class="link link-hover">API</a></li>
        <li><a class="link link-hover">Support</a></li>
      </ul>
    </div>
    <div>
      <p class="font-semibold mb-2">Company</p>
      <ul class="space-y-1">
        <li><a class="link link-hover">About</a></li>
        <li><a class="link link-hover">Careers</a></li>
        <li><a class="link link-hover">Contact</a></li>
      </ul>
    </div>
  </div>
</footer>

</body>
</html>
