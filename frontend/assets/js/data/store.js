/**
 * DG93Store
 * ---------------------------------------------------------------------------
 * Camada única de acesso aos dados MOCK. Toda tela do front-end deve ler e
 * escrever dados através deste objeto — nunca acessar DG93_MOCK diretamente.
 *
 * Isso mantém as páginas desacopladas da origem dos dados: quando o back-end
 * (PHP + MySQL) estiver pronto, basta reescrever os métodos abaixo para
 * fazer fetch() nos endpoints reais, sem precisar tocar nas telas.
 *
 * Persistência: os dados mock são copiados para o localStorage na primeira
 * visita, para que ações como "novo agendamento" ou "cancelar" pareçam
 * reais durante a navegação — nunca em um banco de dados de verdade.
 * ---------------------------------------------------------------------------
 */

const DG93Store = (() => {
  const DB_KEY = 'dg93_mock_db';

  function seedIfNeeded() {
    if (!localStorage.getItem(DB_KEY)) {
      localStorage.setItem(DB_KEY, JSON.stringify(DG93_MOCK));
    }
  }

  function readDb() {
    seedIfNeeded();
    return JSON.parse(localStorage.getItem(DB_KEY));
  }

  function writeDb(db) {
    localStorage.setItem(DB_KEY, JSON.stringify(db));
  }

  function nextId(list, key) {
    return list.reduce((max, item) => Math.max(max, item[key]), 0) + 1;
  }

  return {
    /** Reseta os dados mock para o estado inicial (útil para demonstração). */
    resetMock() {
      localStorage.setItem(DB_KEY, JSON.stringify(DG93_MOCK));
    },

    // ---------- Serviços ----------
    getServicos({ somenteAtivos = false } = {}) {
      const db = readDb();
      return somenteAtivos ? db.servicos.filter(s => s.ativo) : db.servicos;
    },
    getServico(id) {
      return readDb().servicos.find(s => s.id_service === Number(id)) || null;
    },
    salvarServico(servico) {
      const db = readDb();
      if (servico.id_service) {
        const i = db.servicos.findIndex(s => s.id_service === servico.id_service);
        db.servicos[i] = { ...db.servicos[i], ...servico };
      } else {
        servico.id_service = nextId(db.servicos, 'id_service');
        db.servicos.push(servico);
      }
      writeDb(db);
      return servico;
    },
    alternarServicoAtivo(id) {
      const db = readDb();
      const s = db.servicos.find(s => s.id_service === Number(id));
      if (s) { s.ativo = !s.ativo; writeDb(db); }
      return s;
    },

    // ---------- Usuários ----------
    getUsuarios({ perfil } = {}) {
      const db = readDb();
      return perfil ? db.usuarios.filter(u => u.perfil === perfil) : db.usuarios;
    },
    getUsuario(id) {
      return readDb().usuarios.find(u => u.id_user === Number(id)) || null;
    },
    getUsuarioPorEmail(email) {
      return readDb().usuarios.find(u => u.email.toLowerCase() === String(email).toLowerCase()) || null;
    },
    atualizarUsuario(id, dados) {
      const db = readDb();
      const i = db.usuarios.findIndex(u => u.id_user === Number(id));
      if (i === -1) return null;
      db.usuarios[i] = { ...db.usuarios[i], ...dados };
      writeDb(db);
      return db.usuarios[i];
    },
    cadastrarUsuario(dados) {
      const db = readDb();
      const novo = { id_user: nextId(db.usuarios, 'id_user'), perfil: 'cliente', ...dados };
      db.usuarios.push(novo);
      writeDb(db);
      return novo;
    },

    // ---------- Agendamentos ----------
    getAgendamentos({ id_user, status } = {}) {
      let lista = readDb().agendamentos;
      if (id_user) lista = lista.filter(a => a.id_user === Number(id_user));
      if (status) lista = lista.filter(a => a.status === status);
      return [...lista].sort((a, b) => (a.data + a.hora < b.data + b.hora ? 1 : -1));
    },
    getAgendamento(id) {
      return readDb().agendamentos.find(a => a.id_agendamento === Number(id)) || null;
    },
    criarAgendamento({ id_user, id_service, data, hora, local }) {
      const db = readDb();
      const novo = {
        id_agendamento: nextId(db.agendamentos, 'id_agendamento'),
        id_user, id_service, data, hora, local,
        status: 'AGUARDANDO_CONFIRMACAO'
      };
      db.agendamentos.push(novo);
      writeDb(db);
      return novo;
    },
    atualizarStatusAgendamento(id, status) {
      const db = readDb();
      const ag = db.agendamentos.find(a => a.id_agendamento === Number(id));
      if (!ag) return null;
      ag.status = status;
      writeDb(db);
      return ag;
    },
    solicitarReagendamento(id, { data, hora, motivo }) {
      const db = readDb();
      const ag = db.agendamentos.find(a => a.id_agendamento === Number(id));
      if (!ag) return null;
      ag.reagendamento_solicitado = { data, hora, motivo };
      ag.status = 'AGUARDANDO_CONFIRMACAO';
      writeDb(db);
      return ag;
    }
  };
})();
