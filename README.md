# levicavadas.dev

## Visão geral

Este projeto é o portfólio pessoal de Levi Cavadas, hospedado no domínio `levicavadas.dev`. O objetivo do site é apresentar a identidade profissional, o histórico relevante, os projetos em desenvolvimento e os canais de contato de forma direta e fácil de manter.

A implementação foi pensada para ser atualizada sem reescrever a estrutura visual. Os textos, tecnologias, experiências, projetos e links sociais ficam centralizados em arquivos de dados e podem ser alterados em poucos pontos.

O portfólio também integra a documentação e a demo do projeto Mini ERP, que fica em `mini-erp/` e é tratada como uma demonstração separada da aplicação principal em React + TypeScript.

## Objetivos

- Apresentar o perfil de desenvolvimento de software de forma clara;
- Organizar projetos, tecnologias e experiências em uma única interface;
- Manter conteúdo pronto para crescer ao longo do tempo;
- Exibir seções de GitHub e LinkedIn apenas quando houver dados válidos;
- Deixar os projetos e experiências acessíveis sem depender de APIs externas.

## Funcionalidades

- Navegação principal com oito destinos reais: Home, Sobre, Experiência, Projetos, Tecnologias, GitHub, LinkedIn e Contato;
- Hero section com apresentação profissional, ações principais e links sociais condicionais;
- Seção Sobre em texto direto, sem informações inventadas;
- Histórico de experiências organizado em linha do tempo;
- Grid de projetos com cartões reutilizáveis e estados vazios;
- Página de detalhes por slug para cada projeto;
- Seção de tecnologias organizada por categoria;
- Área de GitHub e LinkedIn com estados informativos quando os links ainda não estão configurados;
- Rodapé com navegação essencial e links externos configurados centralmente;
- Projeto Mini ERP registrado com rota de demo demonstrativa e documentação complementar em `mini-erp/`;
- Alternância entre tema claro e escuro com persistência local e preferência do sistema como padrão.

## Tema do portfólio

O site usa um tema claro por padrão, mas respeita a preferência do sistema quando o usuário ainda não escolheu manualmente uma opção. A escolha do usuário é salva em `localStorage` e reaproveitada em visitas futuras.

A lógica do tema é aplicada no `document.documentElement` por meio do atributo `data-theme`, e a configuração inicial também é carregada diretamente em `index.html` para evitar flash visual ao abrir a página.

## Tecnologias do portfólio

- React
- TypeScript
- Vite
- React Router DOM
- ESLint

## Arquitetura do projeto

```text
.
├── public/
│   ├── favicon.svg
│   └── robots.txt
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
│   │   └── ProjectDetailsPage.tsx
│   ├── types/
│   │   └── project.ts
│   ├── App.css
│   ├── App.tsx
│   ├── index.css
│   └── main.tsx
├── .env.example
├── .gitignore
├── index.html
├── package.json
├── README.md
├── tsconfig.json
├── vite.config.ts
└── CLAUDE.md
```

Pontos importantes:

- `src/data/` guarda os dados editáveis do site;
- `src/pages/` concentra as páginas principais;
- `src/components/` reúne os blocos visuais reutilizáveis;
- `src/types/project.ts` define os modelos de dados para projetos, tecnologias e experiências.

## Pré-requisitos

- Node.js 20.19.0 ou superior;
- npm ou outro gerenciador de pacotes compatível com os arquivos do projeto.

## Instalação local

```bash
git clone <url-do-repositorio>
cd levicavadas.dev
npm install
npm run dev
```

A aplicação ficará disponível em uma porta local do Vite; normalmente a URL é `http://localhost:5173`.

## Scripts disponíveis

No `package.json` existem os scripts:

```bash
npm run dev
npm run build
npm run lint
```

- `npm run dev`: inicia o ambiente de desenvolvimento;
- `npm run build`: gera a build de produção;
- `npm run lint`: valida regras do ESLint.

## Configuração de dados pessoais

Os dados pessoais e de contato ficam em `src/data/site.ts`.

```ts
export const siteConfig = {
  name: 'Levi Cavadas',
  domain: 'https://levicavadas.dev',
  role: 'Desenvolvimento de software',
  location: '',
  email: '',
  githubUrl: '',
  linkedinUrl: '',
  heroDescription:
    'Desenvolvimento de software com foco em interfaces claras, aplicações úteis e soluções que são fáceis de manter.',
  about:
    'Eu gosto de construir software com foco em clareza, manutenção e utilidade prática. Também me interessa transformar ideias em projetos pequenos, funcionais e fáceis de evoluir.',
}
```

Campos vazios devem permanecer vazios até que o proprietário confirme o dado. Não invente e-mail, perfil do GitHub, LinkedIn ou endereço.

## Como adicionar um projeto

Os projetos ficam em `src/data/projects.ts`.

1. Abra o arquivo.
2. Adicione um novo objeto ao array `projects`.
3. Informe um `slug` único e legível.
4. Preencha `title`, `summary`, `description`, `status` e `technologies`.
5. Defina `demo` e `github` com o status correto:
   - `available`: link público e válido;
   - `coming-soon`: ainda não disponível;
   - `private`: repositório privado ou não compartilhado;
   - `not-applicable`: sem aplicação ou sem sentido para o projeto.
6. Complete a `architecture` com visão geral, stacks relevantes, fluxo de dados e decisões técnicas.
7. Salve o arquivo; a interface e a página de detalhes serão renderizadas automaticamente.

Exemplo:

```ts
export const projects: Project[] = [
  {
    slug: 'nome-do-projeto',
    title: 'Nome do Projeto',
    summary: 'Resumo curto do projeto.',
    description: 'Descrição completa da necessidade e da solução.',
    status: 'em desenvolvimento',
    technologies: ['React', 'TypeScript', 'Node.js'],
    demo: { url: 'https://example.com', status: 'available' },
    github: { url: 'https://github.com/usuario/projeto', status: 'available' },
    architecture: {
      overview: 'Aplicação web com front-end e API.',
      frontend: ['React', 'TypeScript'],
      backend: ['Node.js'],
      dataFlow: 'O cliente envia requisições para a API e a resposta é exibida em tela.',
      decisions: [
        {
          decision: 'Usar uma API simples para reduzir complexidade.',
          reason: 'O foco era entregar valor rápido e manter o código fácil de evoluir.',
        },
      ],
    },
  },
]
```

> Os exemplos acima servem para orientar a estrutura; o arquivo atual pode permanecer vazio quando não houver projetos reais cadastrados.

## Como documentar a arquitetura de um projeto

Na propriedade `architecture` de cada projeto, o ideal é documentar:

- `overview`: visão geral da solução;
- `frontend`, `backend`, `database`, `integrations`: tecnologias e módulos principais;
- `dataFlow`: como os dados circulam entre interfaces e serviços;
- `decisions`: decisões técnicas com justificativa curta;
- `structure`: caminhos e responsabilidade de módulos ou diretórios importantes.

Essa estrutura ajuda a manter cada projeto legível e permite que a página de detalhes mostre a arquitetura sem criar páginas manuais para cada caso.

## Como adicionar tecnologias e experiências

### Tecnologias

As tecnologias estão em `src/data/technologies.ts`.

Cada item aceita:

- `name`
- `category`
- `description`
- `status` (`estudando`, `em uso`, `explorando`)

Exemplo:

```ts
{
  name: 'Angular',
  category: 'Front-end',
  description: 'Exploração de arquitetura e evolução em aplicações web.',
  status: 'explorando',
}
```

### Experiências

As experiências ficam em `src/data/experience.ts`.

Cada item recebe:

- `role`
- `company`
- `employmentType`
- `startDate`
- `endDate`
- `isCurrent`
- `location`
- `description`
- `responsibilities`
- `technologies`
- `url`

Se ainda não houver um histórico profissional documentado, o componente mostra uma mensagem informativa em vez de criar dados fictícios.

## Build e validação

Para verificar o projeto em um ambiente local:

```bash
npm install
npm run build
npm run lint
```

O build foi validado com sucesso pelo comando de produção e o lint também foi executado sem erros neste workspace.

## Publicação

Para publicar em produção:

1. Ajuste as URLs no arquivo `src/data/site.ts`.
2. Confirme o domínio `levicavadas.dev` no provedor de hospedagem.
3. Configure as entradas de DNS necessárias para apontar o site para a hospedagem escolhida.
4. Faça o deploy do build estático gerado em `dist/`.
5. Verifique se os links e caminhos internos continuam funcionando após a publicação.

Não se deve afirmar que o domínio já está conectado ou publicado sem confirmação técnica do provedor.

## Variáveis de ambiente

O projeto não depende de credenciais no front-end para funcionar. O arquivo `.env.example` foi criado apenas como referência para futuras integrações:

```env
VITE_EMAIL=
VITE_GITHUB_URL=
VITE_LINKEDIN_URL=
```

Nenhum segredo deve ser adicionado ao repositório público.

## Próximas melhorias

- Adicionar projetos reais e materiais de destaque;
- Incluir um formulário de contato com backend ou serviço de envio real;
- Integrar repositórios do GitHub em uma camada automática, se houver interesse futuro;
- Expandir a documentação de projetos com mais cases e detalhes de arquitetura;
- Implementar o backend PHP do Mini ERP em ambiente local com banco e API autenticada, seguindo a documentação em `mini-erp/`.

## Licença

Ainda não há uma licença definida para este repositório. A escolha de licença precisa ser feita antes de um uso público mais amplo, sem inventar uma licença que não exista.
