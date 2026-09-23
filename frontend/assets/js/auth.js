/**
 * DG93Auth
 * Simula uma sessão de usuário logado usando localStorage, apenas para que
 * as telas de cliente/administrador possam ser demonstradas.
 *
 */

const DG93Auth = (() => {
  const SESSION_KEY = 'dg93_session_user_id';

  function login(email) {
    const usuario = DG93Store.getUsuarioPorEmail(email);
    if (!usuario) return null;
    localStorage.setItem(SESSION_KEY, usuario.id_user);
    return usuario;
  }

  function logout() {
    localStorage.removeItem(SESSION_KEY);
  }

  function getUsuarioLogado() {
    const id = localStorage.getItem(SESSION_KEY);
    return id ? DG93Store.getUsuario(id) : null;
  }

  /**
   * Protege uma página: redireciona para o login se ninguém estiver logado,
   * ou para a área correta se o perfil não tiver permissão.
   * @param {'cliente'|'admin'} perfilRequerido
   * @param {string} rootPath caminho relativo até a raiz de frontend/ (ex.: '../')
   */
  function protegerPagina(perfilRequerido, rootPath = '../') {
    const usuario = getUsuarioLogado();
    if (!usuario) {
      window.location.href = `${rootPath}login.html`;
      return null;
    }
    if (perfilRequerido && usuario.perfil !== perfilRequerido) {
      window.location.href = usuario.perfil === 'admin' ? `${rootPath}admin/dashboard.html` : `${rootPath}cliente/dashboard.html`;
      return null;
    }
    return usuario;
  }

  return { login, logout, getUsuarioLogado, protegerPagina };
})();
