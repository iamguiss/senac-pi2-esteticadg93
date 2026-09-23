/**
 * DG93Navbar — navbar da área pública (Início, Serviços, Sobre, Login/Conta).
 * Uso: DG93Navbar.render('inicio');  // 'inicio' | 'servicos' | 'sobre' | ''
 */

const DG93Navbar = (() => {
  function render(active = '') {
    const mount = document.getElementById('dg93-navbar');
    if (!mount) return;

    const usuario = typeof DG93Auth !== 'undefined' ? DG93Auth.getUsuarioLogado() : null;
    const areaHref = usuario ? (usuario.perfil === 'admin' ? 'admin/dashboard.html' : 'cliente/dashboard.html') : null;

    const link = (href, key, label) =>
      `<a href="${href}" ${active === key ? 'aria-current="page"' : ''}>${label}</a>`;

    mount.innerHTML = `
      <div class="container navbar__inner">
        <a href="index.html" class="navbar__brand">Estética DG93<span class="dot">.</span></a>

        <button class="navbar__toggle" id="dg93-navbar-toggle" aria-label="Abrir menu" aria-expanded="false">☰</button>

        <nav class="navbar__links" id="dg93-navbar-links">
          ${link('index.html', 'inicio', 'Início')}
          ${link('servicos.html', 'servicos', 'Serviços')}
          ${link('sobre.html', 'sobre', 'Sobre')}
          <div class="navbar__actions" style="margin-top: 8px;">
            ${usuario
              ? `<a href="${areaHref}" class="btn btn-primary btn-sm">Minha área</a>`
              : `<a href="login.html" class="btn btn-outline btn-sm" style="color:#fff;border-color:#5c5c5c;">Entrar</a>
                 <a href="cadastro.html" class="btn btn-primary btn-sm">Agendar</a>`}
          </div>
        </nav>
      </div>
    `;

    const toggle = document.getElementById('dg93-navbar-toggle');
    const links = document.getElementById('dg93-navbar-links');
    toggle.addEventListener('click', () => {
      const isOpen = links.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(isOpen));
    });
  }

  return { render };
})();
