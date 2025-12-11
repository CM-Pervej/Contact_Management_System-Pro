    </div> <!-- End of main content -->
  </div> <!-- End of flex-1 container (content) -->
</div> <!-- End of horizontal flex (sidebar + content) -->

<!-- Footer -->
<footer class="bg-black text-white text-center p-2 z-50">
  CM Pervej
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
