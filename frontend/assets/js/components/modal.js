/**
 * DG93Modal — abre/fecha modais existentes no HTML da página.
 * Uso: DG93Modal.open('modal-cancelar'); DG93Modal.close('modal-cancelar');
 */

const DG93Modal = (() => {
  function open(id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    const focusable = overlay.querySelector('input, select, textarea, button');
    if (focusable) focusable.focus();
  }

  function close(id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  function bindGlobalCloseEvents() {
    document.addEventListener('click', (e) => {
      if (e.target.matches('[data-modal-close]')) {
        close(e.target.closest('.modal-overlay').id);
      }
      if (e.target.classList.contains('modal-overlay')) {
        close(e.target.id);
      }
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.is-open').forEach(o => close(o.id));
      }
    });
  }

  bindGlobalCloseEvents();

  return { open, close };
})();