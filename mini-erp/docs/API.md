# Mini ERP API

## Visão Geral

A API REST do Mini ERP está versionada em `/api/v1` e usa JSON como formato principal de troca. A autenticação é baseada em sessão de servidor e todas as rotas sensíveis devem ser validadas no backend.

## Convenções

- `200` para requisições concluídas com sucesso;
- `201` para criação;
- `400` para erro de fluxo de negócio;
- `401` para sessão ausente ou inválida;
- `403` para usuário sem permissão;
- `404` para rota ou recurso não encontrado;
- `409` para conflito de dados;
- `422` para validação de campos;
- `500` para falha interna.

## Endpoints principais

### Saúde

`GET /api/v1/health`

Sem autenticação.

Resposta de exemplo:

```json
{
  "success": true,
  "data": {
    "status": "ok",
    "service": "mini-erp",
    "timestamp": "2026-10-19T12:00:00+00:00"
  }
}
```

### Autenticação

`POST /api/v1/auth/login`

Corpo:

```json
{
  "email": "admin@mini-erp.local",
  "password": "admin123"
}
```

Resposta:

```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "Administrador",
      "email": "admin@mini-erp.local",
      "role": "admin"
    }
  }
}
```

`POST /api/v1/auth/logout`

`GET /api/v1/auth/me`

### Usuários

`GET /api/v1/users`

`POST /api/v1/users`

Exemplo:

```json
{
  "name": "Maria Silva",
  "email": "maria@empresa.local",
  "password": "senhaSegura123",
  "role": "operator"
}
```

### Clientes

`GET /api/v1/clients`

`POST /api/v1/clients`

### Produtos

`GET /api/v1/products`

`POST /api/v1/products`

`POST /api/v1/products/{id}/stock/movement`

Exemplo:

```json
{
  "type": "in",
  "quantity": 25,
  "reason": "Compra de material"
}
```

### Vendas

`GET /api/v1/sales`

`POST /api/v1/sales`

Exemplo:

```json
{
  "client_id": 1,
  "discount_type": "percentage",
  "discount_value": 10,
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

### Dashboard

`GET /api/v1/dashboard/summary`

Resposta esperada:

```json
{
  "success": true,
  "data": {
    "sales_total": 0,
    "sales_count": 0,
    "clients_count": 0,
    "products_count": 0,
    "low_stock_count": 0
  }
}
```

## Segurança e autorização

- rotas críticas exigem sessão ativa;
- permissões devem ser validadas no servidor;
- não confiar em `role` informado pelo cliente;
- operações de estoque e vendas usam transação;
- senhas e dados sensíveis ficam em variáveis de ambiente e não são expostos em respostas.
