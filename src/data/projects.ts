import type { Project } from '../types/project'

export const projects: Project[] = [
  {
    slug: 'mini-erp',
    title: 'Mini ERP — Sistema de Gestão Administrativa',
    summary: 'Sistema web para administrar clientes, produtos, estoque, pedidos e indicadores operacionais.',
    description:
      'Este projeto foi pensado para pequenas empresas que precisam centralizar clientes, produtos, movimentações de estoque e pedidos em um ambiente simples de operar. A proposta é manter os processos principais visíveis e organizados sem depender de um ecossistema muito pesado.',
    status: 'em desenvolvimento',
    technologies: ['PHP', 'HTML', 'CSS', 'JavaScript', 'PDO', 'REST API', 'MySQL', 'PostgreSQL'],
    demo: {
      url: '/projetos/mini-erp/demo',
      status: 'available',
    },
    github: {
      url: '',
      status: 'not-applicable',
    },
    architecture: {
      overview:
        'O portfólio continua em React + Vite, enquanto a aplicação administrativa do ERP é um projeto PHP independente com API REST, regras de negócio e banco relacional. A demo interna do portfólio usa dados fictícios em navegador para demonstrar o fluxo do sistema sem depender de publicação real do backend.',
      frontend: ['React + Vite', 'HTML semântico', 'CSS customizado', 'JavaScript de demonstração'],
      backend: ['PHP 8.x', 'PDO', 'API REST em PHP', 'Validação e segurança básica'],
      database: ['MySQL', 'PostgreSQL'],
      integrations: ['Arquivo de documentação OpenAPI', 'Dados fictícios para demo local'],
      dataFlow:
        'O front-end da demo persiste dados em localStorage e o backend PHP, quando executado, processa as regras em API, validações e transações no banco.',
      decisions: [
        {
          decision: 'Separar o portfólio do ERP em projetos distintos.',
          reason: 'Isso mantém a aplicação estática do portfólio leve e preserva a arquitetura do ERP sem misturar responsabilidades.',
        },
        {
          decision: 'Usar banco relacional com transações para estoque e pedidos.',
          reason: 'O sistema precisa manter integridade quando uma venda altera estoque e grava itens ao mesmo tempo.',
        },
      ],
      structure: [
        { path: 'mini-erp/public/', purpose: 'Ponto de entrada da aplicação PHP.' },
        { path: 'mini-erp/src/', purpose: 'Lógica de aplicação, serviços e validação.' },
        { path: 'mini-erp/database/', purpose: 'Migrations e seeders do banco de dados.' },
        { path: 'src/', purpose: 'Portfólio e rota de demonstração do Mini ERP.' },
      ],
    },
    features: [
      'Gestão de usuários com papéis e permissões',
      'Cadastro e filtro de clientes',
      'Produtos, categorias, fornecedores e estoque',
      'Controle de pedidos e itens de venda',
      'Dashboard com indicadores operacionais',
      'Documentação da API e regras de negócio',
    ],
    challenges: [
      'Manter o portfólio sem misturar o frontend estático com a aplicação PHP administrativa.',
      'Garantir que operações de estoque e pedido sejam consistentes mesmo com requisições repetidas.',
      'Documentar permissões e fluxo sem criar uma solução inflada para um projeto de demonstração.',
    ],
    futureImprovements: [
      'Integrar autenticação real em uma instalação PHP separada',
      'Adicionar migrações e seeders completos para MySQL e PostgreSQL',
      'Publicar a API em ambiente compatível com PHP e banco real',
    ],
    period: '2026',
    featured: true,
  },
]

