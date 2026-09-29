/**
 * DG93Footer — rodapé da área pública.
 * Uso: DG93Footer.render();
 */

const DG93Footer = (() => {
  function render() {
    const mount = document.getElementById('dg93-footer');
    if (!mount) return;

    mount.innerHTML = `
      <div class="container">
        <div class="footer-grid">
          <div class="col">
            <h4>Estética DG93</h4>
            <p style="max-width:32ch;">Cuidado automotivo com padrão de oficina profissional: lavagem, higienização e estética para carros, motos e estofados.</p>
          </div>
          <div class="col">
            <h4>Navegação</h4>
            <a href="index.html">Início</a>
            <a href="servicos.html">Serviços</a>
            <a href="sobre.html">Sobre a DG93</a>
          </div>
          <div class="col">
            <h4>Conta</h4>
            <a href="login.html">Entrar</a>
            <a href="cadastro.html">Criar conta</a>
          </div>
          <div class="col">
            <h4>Contato</h4>
            <a href="#">(11) 98185-2831</a>
            <a href="#">contato@dg93.com.br</a>
            <a href="https://www.instagram.com/estetica_dg93_automotiva?utm_source=ig_web_button_share_sheet&stkn=ZDNlZDc0MzIxNw=="
              target="_blank"
              rel="noopener noreferrer"
              style="display:flex; align-items:center; gap:8px;">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  >
              <rect x="2" y="2" width="20" height="20" rx="5"></rect>
              <circle cx="12" cy="12" r="4"></circle>
              <circle cx="17.5" cy="6.5" r="1"></circle>
            </svg>
             @estetica_dg93_automotiva
          </a>
        <div class="footer-bottom">
          <span>&copy; 2026 Estética DG93. Todos os direitos reservados.</span>
          <span>Projeto Integrador — SENAC</span>
        </div>
      </div>
    `;
  }

  return { render };
})();
