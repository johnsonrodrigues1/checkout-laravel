# Checkout Laravel

Esta é uma aplicação Laravel para gerenciar o processo de checkout com suporte para múltiplos métodos de pagamento (PIX,
Cartão de Crédito e Boleto) utilizando Docker e Docker Compose.

## Pré-requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Make](https://www.gnu.org/software/make/)

## Configuração Inicial

1 **Iniciar o projeto**
```bash
  make up
```

2 **Crie o arquivo de ambiente**

Copie o arquivo .env.example para criar o arquivo .env:

```bash
  make env-copy
```

3 **Instale as dependências do Composer**
```bash
  make composer-install
```

4 **Roda as migrations**
```bash
  make fresh
```
5 **Build javascript**
```bash
   make build 
```



