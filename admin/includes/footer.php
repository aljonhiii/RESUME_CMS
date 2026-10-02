<?php
/**
 * Admin Footer Include
 * Closes content wrapper, renders global backdrops, and attaches page-level interactive logic.
 */
?>
    </main>
  </div>

  <!-- Global Backdrop Overlays for Drawers & Modals -->
  <div class="drawer-backdrop"></div>
  <div class="modal-backdrop"></div>

  <script>
    // Toast notification auto-slideout
    document.addEventListener('DOMContentLoaded', function() {
      const toasts = document.querySelectorAll('.admin-toast');
      toasts.forEach(function(toast) {
        setTimeout(function() {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(-10px)';
          setTimeout(function() { toast.remove(); }, 300);
        }, 4000);
      });
    });

    // Confirmation dialog handler
    document.querySelectorAll('[data-confirm]').forEach(function(el) {
      el.addEventListener('click', function(e) {
        if (!confirm(el.getAttribute('data-confirm'))) {
          e.preventDefault();
        }
      });
    });
  </script>
</body>
</html>
