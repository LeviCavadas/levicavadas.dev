# Banco de Dados do Mini ERP

## Visão geral

O Mini ERP utiliza MySQL como banco principal. A estrutura foi modelada para suporte a gestão comercial de pequena escala, com foco em clientes, produtos, estoque, vendas e auditoria.

## Tabelas principais

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
- `schema_migrations`

## Regras de integridade

- chaves estrangeiras para relações entre tabelas;
- `email` e `sku` com unicidade quando aplicável;
- `DECIMAL` para valores monetários;
- estoque com controle explícito por movimentação;
- transação para operações multi-tabela;
- histórico de venda preservado por snapshot do produto na venda.

## Observações

O uso de `FOR UPDATE` para operações de estoque foi previsto para evitar concorrência simples, e as transações são essenciais em rotas de vendas e ajustes de estoque.
