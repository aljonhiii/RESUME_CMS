/**
 * Main Interactive JS Script (GSAP, Navigation, Modals, Contact Form)
 * Aljon Reyes — 3D Developer Portfolio
 */

document.addEventListener('DOMContentLoaded', () => {
  // GSAP Animations Initialization
  if (typeof gsap !== 'undefined') {
    gsap.from('.hero-title', { opacity: 0, y: 40, duration: 1, ease: 'power3.out' });
    gsap.from('.hero-intro', { opacity: 0, x: -30, duration: 1, delay: 0.2, ease: 'power3.out' });
    gsap.from('.hero-3d-wrapper', { opacity: 0, scale: 0.95, duration: 1.2, delay: 0.3, ease: 'power3.out' });
    gsap.from('.hero-overview-panel', { opacity: 0, y: 50, duration: 1.2, delay: 0.4, ease: 'power3.out' });
    gsap.from('.hero-principles-grid .principle-card', {
      opacity: 0,
      y: 20,
      stagger: 0.15,
      duration: 0.8,
      delay: 0.6,
      ease: 'power2.out'
    });
  }

  // Navigation Drawer Modal Toggle
  const menuTrigger = document.getElementById('menu-trigger');
  const navModal = document.getElementById('nav-modal');
  const navModalClose = document.getElementById('nav-modal-close');
  const navLinks = document.querySelectorAll('.nav-links-list a');

  if (menuTrigger && navModal && navModalClose) {
    menuTrigger.addEventListener('click', () => {
      navModal.classList.add('active');
    });

    navModalClose.addEventListener('click', () => {
      navModal.classList.remove('active');
    });

    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navModal.classList.remove('active');
      });
    });
  }

  // Contact Modal Toggle
  const contactBtns = document.querySelectorAll('.trigger-contact');
  const contactModal = document.getElementById('contact-modal');
  const contactModalClose = document.getElementById('contact-modal-close');

  contactBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (contactModal) {
        contactModal.classList.add('active');
      }
    });
  });

  if (contactModalClose && contactModal) {
    contactModalClose.addEventListener('click', () => {
      contactModal.classList.remove('active');
    });

    contactModal.addEventListener('click', (e) => {
      if (e.target === contactModal) {
        contactModal.classList.remove('active');
      }
    });
  }

  // AJAX Contact Form Submission
  const contactForm = document.getElementById('contact-form');
  const formStatus = document.getElementById('form-status-msg');

  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      
      submitBtn.textContent = 'Sending...';
      submitBtn.disabled = true;
      if (formStatus) formStatus.textContent = '';

      const formData = new FormData(contactForm);

      try {
        const response = await fetch('api/contact.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
          if (formStatus) {
            formStatus.style.color = '#27C93F';
            formStatus.textContent = result.message || 'Message sent successfully!';
          }
          contactForm.reset();
          setTimeout(() => {
            if (contactModal) contactModal.classList.remove('active');
            if (formStatus) formStatus.textContent = '';
          }, 2500);
        } else {
          if (formStatus) {
            formStatus.style.color = '#FF5F56';
            formStatus.textContent = result.message || 'Error sending message. Please try again.';
          }
        }
      } catch (err) {
        if (formStatus) {
          formStatus.style.color = '#FF5F56';
          formStatus.textContent = 'Network error. Please try again later.';
        }
      } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  // Project Details Modal Toggle
  const projectModal = document.getElementById('project-modal');
  const projectModalClose = document.getElementById('project-modal-close');
  const projectCards = document.querySelectorAll('.project-card');

  projectCards.forEach(card => {
    const viewBtn = card.querySelector('.btn-view-project');
    if (viewBtn) {
      viewBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const title = card.getAttribute('data-title') || '';
        const category = card.getAttribute('data-category') || '';
        const tech = card.getAttribute('data-tech') || '';
        const desc = card.getAttribute('data-desc') || '';
        const img = card.getAttribute('data-img') || '';

        const repo = card.getAttribute('data-repo') || '#';

        document.getElementById('pm-title').textContent = title;
        document.getElementById('pm-category').textContent = category;
        document.getElementById('pm-desc').textContent = desc;
        document.getElementById('pm-img').src = img;
        
        const pmTechContainer = document.getElementById('pm-tech-tags');
        if (pmTechContainer) {
          pmTechContainer.innerHTML = '';
          tech.split(',').forEach(tag => {
            const span = document.createElement('span');
            span.className = 'tech-pill';
            span.textContent = tag.trim();
            pmTechContainer.appendChild(span);
          });
        }

        const pmRepo = document.getElementById('pm-repo');
        if (pmRepo) pmRepo.href = repo;

        if (projectModal) projectModal.classList.add('active');
      });
    }
  });

  if (projectModalClose && projectModal) {
    projectModalClose.addEventListener('click', () => {
      projectModal.classList.remove('active');
    });

    projectModal.addEventListener('click', (e) => {
      if (e.target === projectModal) {
        projectModal.classList.remove('active');
      }
    });
  }

  // Sticky Header Styling on Scroll
  const topHeader = document.querySelector('.top-header');
  if (topHeader) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 30) {
        topHeader.classList.add('is-scrolled');
      } else {
        topHeader.classList.remove('is-scrolled');
      }
    }, { passive: true });
  }

  // One-Page Scroll Snapping & Active Section Sync Controller
  const snapSections = document.querySelectorAll('.snap-section');
  const dotItems = document.querySelectorAll('.one-page-dots-nav .dot-item');
  const topNavLinks = document.querySelectorAll('.pill-navbar .nav-item, .top-nav-link');

  function setActiveSection(targetId) {
    if (!targetId) return;

    snapSections.forEach(sec => {
      if (sec.getAttribute('id') === targetId) {
        sec.classList.add('is-active');
      } else {
        sec.classList.remove('is-active');
      }
    });

    // Sync side dots navigation
    dotItems.forEach(dot => {
      if (dot.getAttribute('data-target') === targetId) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });

    // Sync top pill navbar navigation links
    topNavLinks.forEach(link => {
      if (link.getAttribute('data-target') === targetId) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  }

  if ('IntersectionObserver' in window && snapSections.length > 0) {
    const visibleRatios = new Map();

    const sectionObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        visibleRatios.set(entry.target.getAttribute('id'), entry.intersectionRatio);
      });

      let maxRatio = 0;
      let activeId = null;
      visibleRatios.forEach((ratio, id) => {
        if (ratio > maxRatio) {
          maxRatio = ratio;
          activeId = id;
        }
      });

      if (activeId && maxRatio > 0.15) {
        setActiveSection(activeId);
      }
    }, {
      threshold: [0, 0.15, 0.35, 0.6, 0.85, 1.0]
    });

    snapSections.forEach(section => sectionObserver.observe(section));
  }

  // Smooth Scroll Click Handlers for Anchor Links & Header Navbar (Excluding Read-Only Side Dots)
  document.querySelectorAll('a[href^="#"]:not(.dot-item)').forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (!href || href === '#') return;

      const targetEl = document.querySelector(href);
      if (targetEl) {
        e.preventDefault();

        const targetId = href.replace('#', '');
        setActiveSection(targetId);

        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Close nav drawer modal if open
        const navModal = document.getElementById('nav-modal');
        if (navModal && navModal.classList.contains('active')) {
          navModal.classList.remove('active');
        }
      }
    });
  });

  // Keyboard Navigation Support (Arrow Up/Down, Page Up/Down, Space, Home, End)
  window.addEventListener('keydown', (e) => {
    const activeEl = document.activeElement;
    if (activeEl && ['INPUT', 'TEXTAREA', 'SELECT'].includes(activeEl.tagName)) return;
    if (document.querySelector('.modal-overlay.active') || document.querySelector('.nav-modal.active')) return;

    const sections = Array.from(document.querySelectorAll('.snap-section'));
    if (sections.length === 0) return;

    let currentIndex = sections.findIndex(sec => sec.classList.contains('is-active'));
    if (currentIndex === -1) {
      const scrollY = window.scrollY;
      currentIndex = sections.reduce((closestIdx, sec, idx) => {
        const offset = Math.abs(sec.offsetTop - scrollY);
        const closestOffset = Math.abs(sections[closestIdx].offsetTop - scrollY);
        return offset < closestOffset ? idx : closestIdx;
      }, 0);
    }

    let targetIndex = -1;

    if (e.key === 'ArrowDown' || e.key === 'PageDown' || (e.key === ' ' && !e.shiftKey)) {
      if (currentIndex < sections.length - 1) targetIndex = currentIndex + 1;
    } else if (e.key === 'ArrowUp' || e.key === 'PageUp' || (e.key === ' ' && e.shiftKey)) {
      if (currentIndex > 0) targetIndex = currentIndex - 1;
    } else if (e.key === 'Home') {
      targetIndex = 0;
    } else if (e.key === 'End') {
      targetIndex = sections.length - 1;
    }

    if (targetIndex !== -1) {
      e.preventDefault();
      const targetSection = sections[targetIndex];
      const targetId = targetSection.getAttribute('id');
      setActiveSection(targetId);
      targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
