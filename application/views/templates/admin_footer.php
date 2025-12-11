    </div><!-- End Main Content -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            setTimeout(function() {
                alert.classList.remove('show');
            }, 5000);
        });
    </script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
    </body>

    </html>