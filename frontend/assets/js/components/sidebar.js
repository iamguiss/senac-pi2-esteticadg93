/**
 * DG93Sidebar — menu lateral + barra superior das áreas logadas.
 * Uso: DG93Sidebar.render({ perfil: 'cliente', active: 'dashboard' });
 */

const DG93Sidebar = (() => {
  const NAV = {
    cliente: [
      { key: 'dashboard', href: 'dashboard.html', icon: '⌂', label: 'Dashboard' },
      { key: 'agendar', href: 'agendar.html', icon: '+', label: 'Agendar serviço' },
      { key: 'agendamentos', href: 'agendamentos.html', icon: '≡', label: 'Meus agendamentos' },
      { key: 'perfil', href: 'perfil.html', icon: '◐', label: 'Meu perfil' }
    ],
    admin: [
      { key: 'dashboard', href: 'dashboard.html', icon: '⌂', label: 'Dashboard' },
      { key: 'agendamentos', href: 'agendamentos.html', icon: '≡', label: 'Agendamentos' },
      { key: 'clientes', href: 'clientes.html', icon: '◈', label: 'Clientes' },
      { key: 'servicos', href: 'servicos.html', icon: '✦', label: 'Serviços' }
    ]
  };

  function render({ perfil, active }) {
    const usuario = DG93Auth.protegerPagina(perfil, '../');
    if (!usuario) return null;

    const sidebarMount = document.getElementById('dg93-sidebar');
    const topbarMount = document.getElementById('dg93-topbar');

    const navHtml = NAV[perfil].map(item => `
      <a class="app-sidebar__link" href="${item.href}" ${item.key === active ? 'aria-current="page"' : ''}>
        <span class="app-sidebar__icon" aria-hidden="true">${item.icon}</span> ${item.label}
      </a>
    `).join('');

    if (sidebarMount) {
      sidebarMount.innerHTML = `
        <div class="app-sidebar__brand"><a href="../index.html" style="color:inherit;">Estética DG93<span class="dot">.</span></a></div>
        <nav class="app-sidebar__nav">${navHtml}</nav>
        <div class="app-sidebar__footer">
          <div class="app-sidebar__user">
            <div class="app-sidebar__avatar">${DG93Utils.initials(usuario.nome)}</div>
            <div>
              <div class="app-sidebar__user-name">${usuario.nome}</div>
              <div class="app-sidebar__user-role">${perfil === 'admin' ? 'Administrador' : 'Cliente'}</div>
            </div>
          </div>
          <button class="btn btn-ghost btn-sm btn-block" id="dg93-logout" style="color:#A6A6A6;">Sair</button>
        </div>
      `;
      document.getElementById('dg93-logout').addEventListener('click', () => {
        DG93Auth.logout();
        window.location.href = '../login.html';
      });
    }

    if (topbarMount) {
      topbarMount.innerHTML = `
        <button class="app-topbar__menu-btn" id="dg93-sidebar-toggle" aria-label="Abrir menu">☰</button>
        <div></div>
      `;
      document.getElementById('dg93-sidebar-toggle').addEventListener('click', () => {
        document.getElementById('dg93-sidebar').classList.toggle('is-open');
      });
    }

    return usuario;
  }

  return { render };
})();
