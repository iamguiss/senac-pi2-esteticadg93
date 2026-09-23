/**
 * Utilitários compartilhados pelo front-end DG93.
 */

const DG93Utils = (() => {
  const STATUS_LABELS = {
    AGUARDANDO_CONFIRMACAO: 'Aguardando confirmação',
    APROVADO: 'Aprovado',
    NEGADO: 'Negado',
    EM_ANDAMENTO: 'Em andamento',
    CONCLUIDO: 'Concluído',
    CANCELADO: 'Cancelado'
  };

  const STATUS_BADGE_CLASS = {
    AGUARDANDO_CONFIRMACAO: 'badge--aguardando',
    APROVADO: 'badge--aprovado',
    NEGADO: 'badge--negado',
    EM_ANDAMENTO: 'badge--andamento',
    CONCLUIDO: 'badge--concluido',
    CANCELADO: 'badge--cancelado'
  };

  function formatCurrency(value) {
    return Number(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  }

  function formatDate(isoDate) {
    if (!isoDate) return '—';
    const [y, m, d] = isoDate.split('-');
    return `${d}/${m}/${y}`;
  }

  function formatDateLong(isoDate) {
    if (!isoDate) return '—';
    const date = new Date(`${isoDate}T00:00:00`);
    return date.toLocaleDateString('pt-BR', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' });
  }

  function statusLabel(status) {
    return STATUS_LABELS[status] || status;
  }

  function statusBadgeHtml(status) {
    return `<span class="badge ${STATUS_BADGE_CLASS[status] || ''}">${statusLabel(status)}</span>`;
  }

  function initials(nome) {
    return nome.trim().split(/\s+/).slice(0, 2).map(p => p[0].toUpperCase()).join('');
  }

  function qs(param) {
    return new URLSearchParams(window.location.search).get(param);
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  return { formatCurrency, formatDate, formatDateLong, statusLabel, statusBadgeHtml, initials, qs, escapeHtml, STATUS_LABELS };
})();
