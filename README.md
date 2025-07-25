# Controle de Pedidos

## Instalação Passo a Passo

### 1. Clone o repositório

```sh
git clone <url-do-repositorio>
cd controle-pedidos
```

### 2. Instale as dependências PHP

```sh
composer install
```

> O CodeIgniter será instalado automaticamente em `vendor/codeigniter/framework/`.
> O arquivo `index.php` já está ajustado para usar o caminho correto do `system`.

### 3. Suba os containers Docker

```sh
docker-compose up -d
```

### 4. Acesse o MySQL dentro do container

```sh
docker-compose exec db mysql -u root -proot
```

### 5. No prompt do MySQL, crie o banco de dados

```sql
CREATE DATABASE controle_pedidos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Importe o schema do banco

```sh
docker-compose exec -T db mysql -u root -proot controle_pedidos < db_schema.sql
```

> **Nota:** Se aparecer o aviso `the input device is not a TTY`, ignore, pois não afeta a importação.

### 7. Acesse o sistema

Abra o navegador e acesse:  
[http://localhost:8081](http://localhost:8081)  
(Ou a porta configurada no seu Docker Compose)

---

## Observações

- O arquivo `application/config/database.php` já está configurado corretamente no repositório para uso com Docker Compose:
  ```php
  'hostname' => 'db',
  'username' => 'root',
  'password' => 'root',
  'database' => 'controle_pedidos',
  'dbdriver' => 'mysqli',
  ...
  ```
- O aviso `the attribute version is obsolete` do Docker Compose pode ser ignorado, mas recomenda-se remover a linha `version:` do `docker-compose.yml` em versões mais recentes.
- O arquivo `application/config/database.php` é criado automaticamente na instalação, mas revise as configurações conforme seu ambiente.
