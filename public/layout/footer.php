    </div> <!-- End of main content -->
  </div> <!-- End of flex-1 container (content) -->
</div> <!-- End of horizontal flex (sidebar + content) -->

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-16 mt-20 z-40">
    <div class="container mx-auto px-6">

        <!-- Top Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

            <!-- Brand -->
            <div>
                <h2 class="text-2xl font-bold text-white tracking-wide">MyApp</h2>
                <p class="text-gray-400 mt-3 leading-relaxed">
                    A modern platform built with PHP OOP & MVC, crafted for performance,
                    scalability, and clean architecture.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center space-x-4 mt-6">
                    <a href="#" class="hover:text-white text-xl"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="hover:text-white text-xl"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-white text-xl"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="hover:text-white text-xl"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>

            <!-- Product Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Product</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="hover:text-white transition">Features</a></li>
                    <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                    <li><a href="#" class="hover:text-white transition">Integrations</a></li>
                    <li><a href="#" class="hover:text-white transition">Roadmap</a></li>
                    <li><a href="#" class="hover:text-white transition">Status</a></li>
                </ul>
            </div>

            <!-- Company Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Company</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition">Press</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Support</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                    <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    <li><a href="#" class="hover:text-white transition">API Reference</a></li>
                    <li><a href="#" class="hover:text-white transition">Community</a></li>
                    <li><a href="#" class="hover:text-white transition">Report Issue</a></li>
                </ul>
            </div>

        </div>

        <!-- Divider -->
        <div class="border-t border-gray-700 my-10"></div>

        <!-- Newsletter Signup -->
        <div class="md:flex items-center justify-between gap-6">

            <h3 class="text-xl font-semibold text-white mb-6 md:mb-0">
                Subscribe for updates, tips & release notes.
            </h3>

            <form class="flex w-full md:w-auto">
                <input
                    type="email"
                    placeholder="Enter your email"
                    class="px-4 py-3 rounded-l-lg bg-gray-800 border border-gray-700 text-gray-200 w-full 
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                />
                <button
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-r-lg transition">
                    Subscribe
                </button>
            </form>

        </div>

        <!-- Bottom Section -->
        <div class="mt-12 md:flex items-center justify-between text-sm text-gray-400">

            <p>
                © <?= date('Y') ?> MyApp — All Rights Reserved.
            </p>

            <div class="flex items-center space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <a href="#" class="hover:text-white transition">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<script>
  // Mobile sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  const toggleBtn = document.getElementById('sidebar-toggle');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  });

  overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
</script>
</body>
</html>
