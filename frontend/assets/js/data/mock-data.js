/**
 * DADOS MOCK — Estética DG93
 * dados de teste  do FRONT-END. Eles espelham (em formato JS) as tabelas definidas em database/database.sql (USUARIOS, SERVICOS, AGENDAMENTO), mas NÃO são uma implementação real de banco de dados nem substituem o back-end.
 */

const DG93_MOCK = {
  usuarios: [
    { id_user: 1, nome: 'Guilherme Prado', email: 'guilherme@dg93.com.br', cpf: '123.456.789-00', sexo: 'Masculino', perfil: 'admin' },
    { id_user: 2, nome: 'Marina Alves', email: 'marina.alves@email.com', cpf: '234.567.891-00', sexo: 'Feminino', perfil: 'cliente' },
    { id_user: 3, nome: 'Rafael Souza', email: 'rafael.souza@email.com', cpf: '345.678.912-00', sexo: 'Masculino', perfil: 'cliente' },
    { id_user: 4, nome: 'Beatriz Lima', email: 'beatriz.lima@email.com', cpf: '456.789.123-00', sexo: 'Feminino', perfil: 'cliente' },
    { id_user: 5, nome: 'João Pedro Costa', email: 'joaopedro@email.com', cpf: '567.891.234-00', sexo: 'Masculino', perfil: 'cliente' }
  ],

  servicos: [
    { id_service: 1, nome_servico: 'Lavagem Completa', categoria: 'Lavagem', preco: 90.00, ativo: true, descricao: 'Lavagem externa e interna com produtos específicos para pintura automotiva.' },
    { id_service: 2, nome_servico: 'Higienização Interna', categoria: 'Higienização', preco: 220.00, ativo: true, descricao: 'Limpeza profunda de bancos, forração, teto e carpetes, com remoção de odores.' },
    { id_service: 3, nome_servico: 'Polimento', categoria: 'Estética', preco: 350.00, ativo: true, descricao: 'Remoção de riscos leves e restauração do brilho da pintura.' },
    { id_service: 4, nome_servico: 'Enceramento', categoria: 'Estética', preco: 150.00, ativo: true, descricao: 'Camada de proteção que realça o brilho e protege contra intempéries.' },
    { id_service: 5, nome_servico: 'Higienização de Estofados (Sofá)', categoria: 'Higienização', preco: 180.00, ativo: true, descricao: 'Limpeza e higienização de sofás residenciais com equipamento profissional.' },
    { id_service: 6, nome_servico: 'Lavagem de Moto', categoria: 'Lavagem', preco: 60.00, ativo: false, descricao: 'Lavagem completa para motocicletas. Temporariamente indisponível.' }
  ],

  agendamentos: [
    { id_agendamento: 101, id_user: 2, id_service: 3, status: 'AGUARDANDO_CONFIRMACAO', data: '2026-09-08', hora: '09:00', local: 'Rua das Acácias, 120 — Jardim Europa' },
    { id_agendamento: 102, id_user: 2, id_service: 1, status: 'CONCLUIDO', data: '2026-08-15', hora: '14:00', local: 'Estética DG93 — Unidade Central' },
    { id_agendamento: 103, id_user: 3, id_service: 2, status: 'APROVADO', data: '2026-09-05', hora: '10:30', local: 'Estética DG93 — Unidade Central' },
    { id_agendamento: 104, id_user: 3, id_service: 4, status: 'EM_ANDAMENTO', data: '2026-09-02', hora: '13:00', local: 'Av. Brasil, 980 — Centro' },
    { id_agendamento: 105, id_user: 4, id_service: 5, status: 'NEGADO', data: '2026-09-01', hora: '08:00', local: 'Rua Bento Gonçalves, 45' },
    { id_agendamento: 106, id_user: 4, id_service: 3, status: 'CANCELADO', data: '2026-08-20', hora: '11:00', local: 'Estética DG93 — Unidade Central' },
    { id_agendamento: 107, id_user: 5, id_service: 1, status: 'AGUARDANDO_CONFIRMACAO', data: '2026-09-10', hora: '15:30', local: 'Rua XV de Novembro, 300' },
    { id_agendamento: 108, id_user: 2, id_service: 4, status: 'APROVADO', data: '2026-09-12', hora: '09:30', local: 'Estética DG93 — Unidade Central' }
  ]
};
