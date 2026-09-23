/**
 * DG93Toast — mensagens de sucesso / erro / aviso flutuantes.
 * Uso: DG93Toast.show('Agendamento enviado com sucesso!', 'success');
 */

const DG93Toast = (() => {
  function ensureStack() {
    let stack = document.querySelector('.toast-stack');
    if (!stack) {
      stack = document.createElement('div');
      stack.className = 'toast-stack';
      stack.setAttribute('role', 'status');
      stack.setAttribute('aria-live', 'polite');
      document.body.appendChild(stack);
    }
    return stack;
  }

  function show(message, type = 'info', duration = 4000) {
    const stack = ensureStack();
    const toast = document.createElement('div');
    toast.className = `toast alert alert--${type}`;
    toast.textContent = message;
    stack.appendChild(toast);
    setTimeout(() => toast.remove(), duration);
  }

  return { show };
})();
