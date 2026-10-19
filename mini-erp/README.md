# Mini ERP — Sistema de Gestão Administrativa

## Visão geral

Este diretório contém a implementação do backend PHP do Mini ERP para o portfólio `levicavadas.dev`. O objetivo do sistema é aplicar as regras de uma pequena operação comercial com foco em clientes, produtos, estoque, vendas e indicadores operacionais.

A aplicação foi organizada em módulos separando configuração, autenticação, serviços, regras de negócio e banco de dados. O portfólio em React continua separado da aplicação administrativa e a demo interna permanece uma demonstração local com dados fictícios, sem persistência real no servidor.

## Estado atual da implementação

- Backend em PHP estruturado com bootstrap, roteamento básico, autenticação e serviços;
- Modelagem MySQL com migrações em ordem e scripts de instalação;
- Entidades principais para usuários, clientes, categorias, fornecedores, produtos, estoque, vendas, pagamentos e auditoria;
- API REST versionada em `/api/v1` com rotas de autenticação, clientes, produtos, vendas e dashboard;
- Documentação técnica, segurança e banco em arquivos dedicados;
- Sem publicação real em produção confirmada.

## Objetivos do sistema

- gerir clientes e usuários com controlo de acesso;
- manter cadastrados produtos, categorias e fornecedores;
- controlar saldo de estoque com registro de movimentações;
- criar vendas com totais recalculados no servidor;
- disponibilizar um dashboard de resumo operacionais;
- registrar auditoria e erros de forma centralizada.

## Funcionalidades implementadas

- autenticação por sessão para usuários ativos;
- criação de usuários com papéis definidos (`admin`, `manager`, `operator`, `consult`);
- listagem de clientes e produtos;
- criação de clientes e produtos com validação mínima do servidor;
- registro de movimentações de estoque (`in`, `out`, `adjustment`);
- criação de vendas com cálculo de subtotal, desconto e total no backend;
- armazenamento do histórico de itens da venda;
- dashboard resumido de faturamento e contadores;
- migração de banco e seed de desenvolvimento;
- scripts de criação do primeiro administrador.

## Tecnologias utilizadas

- PHP 8.2+
- PDO
- MySQL 8+
- Composer
- PHPUnit
- JSON para API

## Estrutura de diretórios

```text
mini-erp/
├── .env.example
├── .gitignore
├── composer.json
├── phpunit.xml
├── README.md
├── database/
│   ├── migrations/
│   └── seeds/
├── docs/
│   ├── API.md
│   ├── DATABASE.md
│   ├── SECURITY.md
│   └── api/
│       └── openapi.yaml
├── public/
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── api.php
├── scripts/
│   ├── create-admin.php
│   ├── migrate.php
│   └── seed.php
├── src/
│   ├── Config/
│   ├── Core/
│   ├── Middleware/
│   ├── Services/
│   └── Support/
└── tests/
    └── Integration/
```

## Requisitos do ambiente

- PHP 8.2 ou superior;
- extensões necessárias do PHP: `pdo`, `pdo_mysql`, `json` e `session`;
- MySQL 8.0 ou superior;
- Composer para autoload e execução de scripts;
- acesso local ao banco configurado em `.env`.

## Configuração local no Windows (confirmada)

No ambiente atual, o PHP executado pelo terminal foi o binário instalado via WinGet:

```powershell
where.exe php
php --ini
php -m | Select-String -Pattern '^PDO$|^pdo_mysql$'
```

O projeto também contém um arquivo local `php.ini` que carrega corretamente a extensão `pdo_mysql` quando o servidor é iniciado com:

```powershell
& 'C:\Users\levic\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe' -c .\php.ini -S 127.0.0.1:8080 -t public
```

Se o PHP da instalação padrão não carregar a extensão, o ajuste correto é habilitar a linha no `php.ini` efetivamente usado pelo runtime:

```ini
extension_dir = "C:/.../php/ext"
extension = pdo_mysql
```

Antes de editar, faça backup do arquivo de configuração:

```powershell
Copy-Item .\php.ini ".\php.ini.backup-$(Get-Date -Format 'yyyy-MM-dd-HHmmss')" -Force
```

## Configuração e variáveis de ambiente

Use o arquivo `.env.example` como base e copie para `.env` antes da execução local:

```bash
cp .env.example .env
```

Conteúdo esperado:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080
APP_KEY=CHANGE_ME_WITH_A_RANDOM_SECRET
APP_TIMEZONE=America/Sao_Paulo

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_erp
DB_USERNAME=mini_erp_app
DB_PASSWORD=CHANGE_ME
DB_CHARSET=utf8mb4

SESSION_NAME=mini_erp_session
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=Lax
SESSION_IDLE_TIMEOUT=1800
LOG_LEVEL=debug
CORS_ALLOWED_ORIGINS=
```

> O arquivo `.env` não deve ser commitado e não deve conter segredos reais em repositório.

## Instalação local

1. Instale as dependências do PHP:

```bash
composer install
```

2. Configure o banco MySQL e crie o banco `mini_erp`.

3. Crie o primeiro usuário administrador:

```bash
php scripts/create-admin.php "Administrador" "admin@mini-erp.local" "admin123"
```

4. Rode as migrações:

```bash
php scripts/migrate.php
```

5. Popular dados de demonstração:

```bash
php scripts/seed.php
```

6. Inicie o servidor local:

```bash
php -S 127.0.0.1:8080 -t public
```

7. Acesse a API em:

```text
http://127.0.0.1:8080/api/v1/health
```

## Scripts disponíveis

A partir do `composer.json`, os scripts definidos são:

```bash
composer migrate
composer seed
composer admin -- "Administrador" "admin@mini-erp.local" "admin123"
composer test
```

## Banco de dados e migrações

As migrações são executadas em ordem cronológica por arquivos em `database/migrations/` e cada um registra a execução em `schema_migrations`.

### Estrutura principal

- `users`
- `clients`
- `categories`
- `suppliers`
- `products`
- `stock_movements`
- `sales`
- `sale_items`
- `payments`
- `audit_logs`

### Regras de integridade

- valores monetários em `DECIMAL`;
- quantidades inteiras e não negativas quando aplicável;
- uso de chaves estrangeiras;
- exclusão lógica ou bloqueio em casos de histórico sensível;
- rastreio de movimentação do estoque;
- dados de auditoria sem armazenar senhas, tokens ou cartões.

## API REST

A API está disponível em `/api/v1` e inclui os principais endpoints:

- `GET /api/v1/health`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout`
- `GET /api/v1/auth/me`
- `GET /api/v1/users`
- `POST /api/v1/users`
- `GET /api/v1/clients`
- `POST /api/v1/clients`
- `GET /api/v1/products`
- `POST /api/v1/products`
- `POST /api/v1/products/{id}/stock/movement`
- `GET /api/v1/sales`
- `POST /api/v1/sales`
- `GET /api/v1/dashboard/summary`

A documentação detalhada está em [docs/API.md](docs/API.md) e a especificação OpenAPI em [docs/api/openapi.yaml](docs/api/openapi.yaml).

## Regras de negócio implementadas

- autenticação com sessão e validação de usuário ativo;
- login sem revelar se o e-mail existe;
- senhas armazenadas com `password_hash()` e verificadas com `password_verify()`;
- diferença de papéis e controle de acesso no servidor;
- preços, produtos e quantidades validados antes de confirmar operações;
- redução de estoque no momento da criação da venda;
- regra mínima de estoque e registro em `stock_movements`;
- total e descontos recalculados pelo backend;
- no mínimo, um item válido por venda;
- operações com transação para garantir consistência do banco.

## Segurança

- uso de `password_hash()` e `password_verify()`;
- cookies com `HttpOnly` e `SameSite` configuráveis;
- sessão iniciada pelo servidor e destruída ao logout;
- respostas JSON padronizadas para erros;
- prepared statements por PDO;
- ausência de stack traces em produção;
- não publicação de `.env`, senhas ou tokens.

Consulte também [docs/SECURITY.md](docs/SECURITY.md).

## Testes

O projeto inclui estrutura base para PHPUnit em `tests/Integration`, com foco em autenticação, criação de clientes e regras de negócio. Por falta de runtime PHP disponível no ambiente atual, os testes ainda não puderam ser executados aqui; a suíte foi estruturada para rodar no ambiente do desenvolvedor com PHP e Composer instalados.

## Limitações verificadas

- este ambiente não possui PHP ou MySQL instalados no PATH;
- não foi possível executar `php`, `composer` ou `mysql` nesta sessão;
- portanto, a execução real de migrações, ordem de SQL e testes ficou pendente até que o runtime do PHP esteja disponível no ambiente local.

## Publicação e manutenção

Para publicar em produção, o documento raiz deve apontar para `public/`, o banco deve estar configurado em `.env` e o servidor deve emular HTTPS. A aplicação deve permanecer separada do portfólio estático em React/Vite.

O sistema é tratado como backend funcional em desenvolvimento, mas sem confirmação de publicação no domínio ou deploy real realizado neste ambiente.
