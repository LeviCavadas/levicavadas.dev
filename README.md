# levicavadas.dev

## Visão geral

Este repositório contém o portfólio pessoal de Levi Cavadas. O objetivo do site é apresentar o perfil profissional, experiências relevantes, projetos em destaque, tecnologias e canais de contato de forma organizada e fácil de manter.

A aplicação é estruturada como um frontend em React + TypeScript com dados centralizados em arquivos do diretório `src/data/`. Em vez de fixar conteúdo diretamente em componentes, o projeto usa uma abordagem baseada em configuração e dados para facilitar atualização e manutenção.

Além do portfólio, o repositório inclui uma demonstração do projeto Mini ERP em `mini-erp/`, que funciona como uma subaplicação separada e não é parte da navegação principal do site.

## Objetivo do projeto

- Apresentar o perfil de desenvolvimento de software de forma clara e direta;
- Organizar projetos, experiências e tecnologias em uma única interface;
- Exibir o portfólio com navegação e layout responsivo;
- Centralizar textos e links em arquivos de dados;
- Incluir uma demonstração do Mini ERP com dados fictícios e leitura restrita.

## Tecnologias utilizadas

O portfólio usa as tecnologias confirmadas no código e nos arquivos de configuração do projeto:

- React 19
- TypeScript
- Vite
- React Router DOM
- CSS customizado com variáveis de tema
- ESLint para validação estática

A subaplicação Mini ERP em `mini-erp/` usa um conjunto complementar de tecnologias dentro do próprio workspace:

- PHP 8.x
- PDO
- MySQL
- Composer
- PHPUnit
- API REST em PHP

## Funcionalidades implementadas

O site atual implementa as seguintes partes verificadas no código:

- página inicial com apresentação profissional, navegação e seções principais;
- seção de sobre o perfil e forma de trabalho;
- linha do tempo de experiências com dados configuráveis;
- grid de projetos com páginas de detalhe por slug;
- área de tecnologias organizada por categoria;
- bloco de GitHub e LinkedIn com renderização condicional do conteúdo;
- seção de contato com links e e-mail quando disponíveis;
- rodapé com marca, navegação e redes sociais;
- alternância entre tema claro e escuro com persistência em `localStorage`;
- rota de demonstração para o Mini ERP com dados fictícios e aviso de modo somente leitura.

A demo do Mini ERP, em `src/pages/ProjectDemoPage.tsx`, é demonstrativa e não permite alteração de estado: ela navega por um conjunto de dados fictícios e exibe um banner informando que a operação é somente leitura.

## Arquitetura e organização do código

```text
.
├── public/
│   └── assets estáticos do site
├── src/
│   ├── components/
│   │   ├── layout/
│   │   │   ├── Footer.tsx
│   │   │   ├── Header.tsx
│   │   │   └── SectionHeading.tsx
│   │   └── projects/
│   │       ├── ProjectCard.tsx
│   │       ├── ProjectGrid.tsx
│   │       └── ProjectLinks.tsx
│   ├── data/
│   │   ├── experience.ts
│   │   ├── github.ts
│   │   ├── projects.ts
│   │   ├── site.ts
│   │   └── technologies.ts
│   ├── pages/
│   │   ├── HomePage.tsx
│   │   ├── ProjectDetailsPage.tsx
│   │   └── ProjectDemoPage.tsx
│   ├── types/
│   │   └── project.ts
│   ├── App.css
│   ├── App.tsx
│   ├── index.css
│   └── main.tsx
├── mini-erp/
│   ├── README.md
│   ├── public/
│   ├── src/
│   ├── routes/
│   ├── database/
│   ├── docs/
│   └── tests/
├── .gitignore
├── index.html
├── package.json
├── README.md
├── tsconfig.json
├── tsconfig.app.json
├── tsconfig.node.json
├── vite.config.ts
└── eslint.config.js
```

### Pontos importantes da arquitetura

- `src/App.tsx` define o roteamento principal e aplica o tema do documento;
- `src/data/` concentra textos, projetos, tecnologias, experiências e links configuráveis;
- `src/components/` reúne blocos visuais reutilizáveis e layout compartilhado;
- `src/pages/` organiza as páginas públicas do portfólio;
- `mini-erp/` é um subprojeto independente, com backend PHP e documentação específica;
- o site em si não depende de backend externo para funcionar como portfólio estático.

## Tema e estilo

O tema do portfólio é implementado por meio de `data-theme` no `document.documentElement` e de variáveis CSS definidas em `src/App.css`. O código também verifica a preferência de tema do sistema e salva a escolha do usuário em `localStorage` quando ela é alterada manualmente.

Esse comportamento aparece em `src/App.tsx` e é usado para manter uma visualização clara tanto em modo claro quanto em modo escuro.

## Dados e conteúdo

Os textos e as informações principais do site são mantidos em arquivos do diretório `src/data/`:

- `site.ts`: perfil, nome, e-mail e links públicos;
- `projects.ts`: projetos e arquitetura descrita por item;
- `experience.ts`: histórico profissional e contextos relevantes;
- `technologies.ts`: tecnologias e categoria de uso;
- `github.ts`: repositórios destacados.

Essa estrutura permite que a documentação e a apresentação do portfólio sejam atualizadas sem duplicar conteúdo entre componentes.

## Demo do Mini ERP

A demo do Mini ERP exibida pelo portfólio é uma apresentação visual do fluxo do sistema, não uma aplicação administrativa funcional em produção. O comportamento real está documentado em `src/pages/ProjectDemoPage.tsx`:

- os dados são estáticos;
- o componente exibe uma mensagem de somente leitura;
- a interface mostra dashboard, clientes, produtos e vendas fictícios;
- não há persistência real de alterações no navegador.

## APIs e integrações

O portfólio principal não utiliza uma API externa para renderizar o conteúdo do site. A maioria das informações é estática e alimentada pelos arquivos em `src/data/`.

O Mini ERP em `mini-erp/` é a parte do workspace que possui backend e API própria, com documentação específica em seu diretório. Esse projeto é independente do frontend do portfólio e deve ser tratado como um ambiente separado.

## Estado do projeto

O projeto está em uma etapa de documentação e manutenção do portfolio, com o frontend configurado e com uma demo do Mini ERP integrada como parte da apresentação. A parte administrativa do ERP continua sendo um projeto separado com documentação própria e não deve ser tratada como backend do site principal.


## Observações finais

- O README principal foi ajustado para refletir a estrutura real do projeto.
- Tutoriais de instalação e setup local foram removidos do documento principal.
- A documentação mantém foco em arquitetura, stack real, organização e funcionalidades implementadas.
- Não foram inventadas tecnologias, rotas ou integrações que não existam no código atual.


## Variáveis de ambiente

O projeto não depende de credenciais no front-end para funcionar. O arquivo `.env.example` foi criado apenas como referência para futuras integrações:

```env
VITE_EMAIL=
VITE_GITHUB_URL=
VITE_LINKEDIN_URL=
```


## Próximas melhorias

- Adicionar projetos reais e materiais de destaque;
- Incluir um formulário de contato com backend ou serviço de envio real;
- Integrar repositórios do GitHub em uma camada automática, se houver interesse futuro;
- Expandir a documentação de projetos com mais cases e detalhes de arquitetura;
- Implementar o backend PHP do Mini ERP em ambiente local com banco e API autenticada, seguindo a documentação em `mini-erp/`.

## Licença


