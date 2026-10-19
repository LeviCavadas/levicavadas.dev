# Segurança do Mini ERP

## Princípios

- autenticação com sessão do servidor;
- acesso restrito por papel e permissão no backend;
- senhas armazenadas com `password_hash()`;
- uso de prepared statements em PDO;
- cookies com `HttpOnly` e `SameSite` configuráveis;
- ausência de segredos em repositório;
- respostas de erro sem expor stack trace.

## Checklist de segurança

- `.env` fora do controle de versão;
- `APP_DEBUG=false` em produção;
- HTTPS em ambiente público;
- bloqueio de CSRF para ações autenticadas;
- logs sem dados sensíveis;
- auditoria para ações críticas.
