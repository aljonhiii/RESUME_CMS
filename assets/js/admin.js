/**
 * Admin CMS Component Controller
 * Handles slide-over drawers, modals, image previews, and interactive components.
 */

document.addEventListener('DOMContentLoaded', () => {
  // Global Escape key listener to close active overlays
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      AdminDrawer.closeAll();
      AdminModal.closeAll();
    }
  });

  // Attach backdrop click listeners
  document.querySelectorAll('.drawer-backdrop, .modal-backdrop').forEach((backdrop) => {
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) {
        AdminDrawer.closeAll();
        AdminModal.closeAll();
      }
    });
  });

  // Attach data-drawer-target triggers
  document.querySelectorAll('[data-drawer-target]').forEach((trigger) => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-drawer-target');
      AdminDrawer.open(targetId, trigger);
    });
  });

  // Attach data-modal-target triggers
  document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-modal-target');
      AdminModal.open(targetId, trigger);
    });
  });

  // Close buttons inside drawers/modals
  document.querySelectorAll('[data-close-drawer]').forEach((btn) => {
    btn.addEventListener('click', () => AdminDrawer.closeAll());
  });

  document.querySelectorAll('[data-close-modal]').forEach((btn) => {
    btn.addEventListener('click', () => AdminModal.closeAll());
  });

  // Image input preview handler
  document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
    input.addEventListener('change', (e) => {
      const targetSelector = input.getAttribute('data-preview');
      const previewEl = document.querySelector(targetSelector);
      if (previewEl && input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (evt) => {
          if (previewEl.tagName === 'IMG') {
            previewEl.src = evt.target.result;
            previewEl.style.display = 'block';
          } else {
            previewEl.style.backgroundImage = `url(${evt.target.result})`;
          }
        };
        reader.readAsDataURL(input.files[0]);
      }
    });
  });
});

/**
 * Slide-over Drawer Controller
 */
window.AdminDrawer = {
  open: (drawerId, triggerEl = null) => {
    const drawer = document.getElementById(drawerId);
    if (!drawer) return;

    // Reset form if trigger has dataset values or reset flag
    const form = drawer.querySelector('form');
    if (form) {
      if (triggerEl && triggerEl.dataset.resetForm === 'true') {
        form.reset();
        const idInput = form.querySelector('input[name="id"]');
        if (idInput) idInput.value = '';
        const titleEl = drawer.querySelector('.drawer-title');
        if (titleEl && triggerEl.dataset.drawerTitle) {
          titleEl.textContent = triggerEl.dataset.drawerTitle;
        }
        // Reset preview if any
        const imgPreview = drawer.querySelector('.img-preview');
        if (imgPreview) {
          imgPreview.src = '';
          imgPreview.style.display = 'none';
        }
      } else if (triggerEl) {
        // Populate form fields from trigger dataset (handles both snake_case and camelCase)
        Array.from(triggerEl.attributes).forEach((attr) => {
          if (attr.name.startsWith('data-')) {
            const rawKey = attr.name.slice(5); // e.g. "proficiency_display", "short_description", "id"
            if (['drawer-target', 'drawer-title', 'img-src', 'reset-form'].includes(rawKey)) return;

            // Try exact attribute name first (snake_case), then camelCase
            let field = form.querySelector(`[name="${rawKey}"]`);
            if (!field) {
              const camelKey = rawKey.replace(/_([a-z])/g, (g) => g[1].toUpperCase());
              field = form.querySelector(`[name="${camelKey}"]`);
            }

            if (field) {
              if (field.type === 'checkbox') {
                field.checked = attr.value === '1' || attr.value === 'true';
              } else {
                field.value = attr.value;
              }
            }
          }
        });
        
        // Update drawer header title if specified
        if (triggerEl.dataset.drawerTitle) {
          const titleEl = drawer.querySelector('.drawer-title');
          if (titleEl) titleEl.textContent = triggerEl.dataset.drawerTitle;
        }

        // Handle image preview dataset
        if (triggerEl.dataset.imgSrc) {
          const imgPreview = drawer.querySelector('.img-preview');
          if (imgPreview) {
            imgPreview.src = triggerEl.dataset.imgSrc;
            imgPreview.style.display = 'block';
          }
        }
      }
    }

    drawer.classList.add('active');
    document.body.style.overflow = 'hidden';
  },

  close: (drawerId) => {
    const drawer = document.getElementById(drawerId);
    if (drawer) {
      drawer.classList.remove('active');
      document.body.style.overflow = '';
    }
  },

  closeAll: () => {
    document.querySelectorAll('.admin-drawer.active').forEach((drawer) => {
      drawer.classList.remove('active');
    });
    document.body.style.overflow = '';
  }
};

/**
 * Modal Overlay Controller
 */
window.AdminModal = {
  open: (modalId, triggerEl = null) => {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    if (triggerEl) {
      // If modal displays dynamic message details
      const subjectTarget = modal.querySelector('[data-field="subject"]');
      const nameTarget = modal.querySelector('[data-field="name"]');
      const emailTarget = modal.querySelector('[data-field="email"]');
      const dateTarget = modal.querySelector('[data-field="date"]');
      const bodyTarget = modal.querySelector('[data-field="body"]');
      const replyBtn = modal.querySelector('[data-field="reply-link"]');

      if (subjectTarget && triggerEl.dataset.subject) subjectTarget.textContent = triggerEl.dataset.subject;
      if (nameTarget && triggerEl.dataset.name) nameTarget.textContent = triggerEl.dataset.name;
      if (emailTarget && triggerEl.dataset.email) emailTarget.textContent = triggerEl.dataset.email;
      if (dateTarget && triggerEl.dataset.date) dateTarget.textContent = triggerEl.dataset.date;
      if (bodyTarget && triggerEl.dataset.body) bodyTarget.textContent = triggerEl.dataset.body;

      if (replyBtn && triggerEl.dataset.email) {
        const subject = encodeURIComponent(`Re: ${triggerEl.dataset.subject || 'Portfolio Inquiry'}`);
        replyBtn.href = `mailto:${triggerEl.dataset.email}?subject=${subject}`;
      }
    }

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  },

  close: (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  },

  closeAll: () => {
    document.querySelectorAll('.admin-modal.active').forEach((modal) => {
      modal.classList.remove('active');
    });
    document.body.style.overflow = '';
  }
};
