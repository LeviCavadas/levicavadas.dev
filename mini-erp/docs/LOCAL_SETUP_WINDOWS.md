# Mini ERP — Local setup no Windows

## Requisitos verificados

- Windows 10/11
- PHP 8.4.25 via WinGet
- MySQL 8.4.9 via instalador oficial
- Composer 2.10.3 instalado no perfil do usuário

## Instalação do ambiente

1. Confirmar que o PHP e o MySQL estão no PATH do terminal atual.
2. Instalar o PHP e o MySQL usando os instaladores oficiais ou `winget`.
3. Instalar o Composer com o instalador oficial do Composer usando o PHP local.
4. Criar o arquivo `.env` local a partir do valor abaixo, sem versionar segredos reais.

## Variáveis locais esperadas

```dotenv
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8080
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=mini_erp_dev
DB_USER=mini_erp_app
DB_PASSWORD=MiniErpDev!2026
DB_CHARSET=utf8mb4
```

## Iniciar o MySQL local

```powershell
& 'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysqld.exe' --defaults-file='C:\Users\levic\mysql-local\my.ini' --console
```

> O banco local foi inicializado em `C:\Users\levic\mysql-local` para respeitar as permissões do Windows e evitar alterações em diretórios do sistema.

## Preparar o banco

```powershell
& 'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysql.exe' -uroot -e "CREATE DATABASE IF NOT EXISTS mini_erp_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS 'mini_erp_app'@'127.0.0.1' IDENTIFIED BY 'MiniErpDev!2026'; GRANT ALL PRIVILEGES ON mini_erp_dev.* TO 'mini_erp_app'@'127.0.0.1'; FLUSH PRIVILEGES;"
```

## Executar o projeto

```powershell
cd c:\Users\levic\levicavadas.dev\mini-erp
php -c .\php.ini .\scripts\migrate.php
php -c .\php.ini .\scripts\seed.php
php -c .\php.ini -S 127.0.0.1:8080 -t public
```

A API fica em:

- http://127.0.0.1:8080/api/v1/health
- http://127.0.0.1:8080/api/v1/auth/login

## Testes

```powershell
cd c:\Users\levic\levicavadas.dev\mini-erp
php -c .\php.ini .\vendor\bin\phpunit --testdox
```

## Problemas comuns

- `php` não reconhecido: use o caminho completo do executável do WinGet ou reinicie o terminal.
- `pdo_mysql` ausente: habilite `extension = pdo_mysql` no `php.ini` local do projeto.
- MySQL sem serviço: inicie manualmente com o comando acima.
- Porta 3306 ocupada: verificar quem está usando a porta e escolher outra opção local.
- Permissões do Windows: o arquivo de configuração do MySQL foi alocado em `C:\Users\levic\mysql-local` para manter a configuração local segura.
