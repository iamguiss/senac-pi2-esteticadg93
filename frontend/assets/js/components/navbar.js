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
    <a href="${location.pathname.includes('/cliente/') || location.pathname.includes('/admin/') ? '../index.html' : 'index.html'}" class="navbar__brand">
      <img
        src="${location.pathname.includes('/cliente/') || location.pathname.includes('/admin/')
                ? '../assets/img/logo-dg93.png'
                : 'assets/img/logo-dg93.png'}"
                alt="Estética DG93"
         style="height: 50px; width: auto; display: block;"
        >
    </a>

    <button class="navbar__toggle" id="dg93-navbar-toggle" aria-label="Abrir menu" aria-expanded="false">☰</button>

    <nav class="navbar__links" id="dg93-navbar-links">
      ${link(
                    location.pathname.includes('/cliente/') || location.pathname.includes('/admin/')
                        ? '../index.html'
                        : 'index.html',
                    'inicio',
                    'Início'
                )}
      ${link(
                    location.pathname.includes('/cliente/') || location.pathname.includes('/admin/')
                        ? '../servicos.html'
                        : 'servicos.html',
                    'servicos',
                    'Serviços'
                )}

      ${link(
                    location.pathname.includes('/cliente/') || location.pathname.includes('/admin/')
                        ? '../sobre.html'
                        : 'sobre.html',
                    'sobre',
                    'Sobre'
                )}

      <div class="navbar__actions" style="margin-top: 8px;">
        ${usuario
                ? `<a href="${areaHref}" class="btn btn-primary btn-sm">Minha área</a>`
                : `<a href="${location.pathname.includes('/cliente/') || location.pathname.includes('/admin/') ? '../login.html' : 'login.html'}" class="btn btn-outline btn-sm" style="color:#fff;border-color:#5c5c5c;">Entrar</a>
             <a href="${location.pathname.includes('/cliente/') || location.pathname.includes('/admin/') ? '../cadastro.html' : 'cadastro.html'}" class="btn btn-primary btn-sm">Agendar</a>`}
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
