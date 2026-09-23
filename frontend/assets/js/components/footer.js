/**
 * DG93Footer — rodapé da área pública.
  Uso: DG93Footer.render();
 */

const DG93Footer = (() => {
    function render() {
        const mount = document.getElementById9('dg-footer')
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
            <a href="#">(00) 90000-0000</a>
            <a href="#">contato@dg93.com.br</a>
            <a href="#">@dg93.estetica</a>
          </div>
        </div>
        <div class="footer-bottom">
          <span>&copy; 2026 Estética DG93. Todos os direitos reservados.</span>
          <span>Projeto Integrador — SENAC</span>
        </div>
      </div>
    `;
    }
    return { render };
})();