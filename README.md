# controle-pedidos

# 🛒 Sistema de E-commerce - Mini ERP

Sistema completo de e-commerce desenvolvido em CodeIgniter 3 com interface moderna em Bootstrap, incluindo controle de produtos, estoque, carrinho de compras, cupons de desconto e finalização de pedidos.

## 📋 Funcionalidades

### ✨ **Principais Features**
- 🛍️ **Gestão de Produtos** - Cadastro completo com variações e controle de estoque
- 🛒 **Carrinho Inteligente** - Controle granular de quantidades com validação de estoque
- 🎫 **Sistema de Cupons** - Cupons com validação de data e valor mínimo
- 📍 **Busca Automática de CEP** - Integração com ViaCEP para preenchimento automático
- 📧 **E-mail de Confirmação** - Envio automático ao finalizar pedidos
- 🔗 **Webhook** - Endpoint para atualização de status de pedidos
- 💰 **Cálculo Automático de Frete** - Regras baseadas no valor do pedido

### 🎨 **Interface Moderna**
- Design responsivo com Bootstrap 5
- Navegação intuitiva com ícones contextuais
- Feedback visual em todas as ações
- Modal elegante para confirmações
- Layout otimizado sem necessidade de scroll

## 🛠️ Tecnologias Utilizadas

- **Backend:** CodeIgniter 3
- **Frontend:** Bootstrap 5 + Bootstrap Icons
- **Banco de Dados:** MySQL
- **APIs:** ViaCEP para consulta de endereços
- **E-mail:** Biblioteca nativa do CodeIgniter

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **Docker** e **Docker Compose**
- **Git** para clonar o repositório

## 🚀 Instalação e Configuração

### 🐳 **Método 1: Docker (Recomendado)**

#### **1. Clone o Repositório:**
```bash
git clone [URL_DO_REPOSITORIO]
cd controle-pedidos
```

#### **2. Subir os Containers:**
```bash
docker-compose up -d
```

#### **3. Instalar Dependências:**
```bash
docker-compose exec app composer install
```

#### **4. Importar o Banco de Dados:**
```bash
# Aguardar o MySQL inicializar (cerca de 30 segundos)
docker-compose exec db mysql -u root -proot controle_pedidos < db_schema.sql
```

#### **5. Acessar o Sistema:**
```
http://localhost:8081/produtos
```

### 💻 **Método 2: Instalação Local**

#### **Pré-requisitos Locais:**
- **PHP 7.4+** ou superior
- **MySQL 5.7+** ou superior
- **Apache/Nginx** com mod_rewrite
- **Composer**

#### **1. Clone e Configure:**
```bash
git clone [URL_DO_REPOSITORIO]
cd controle-pedidos
composer install
```

#### **2. Configurar Banco de Dados:**
```bash
# Criar banco
mysql -u root -p
CREATE DATABASE controle_pedidos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Importar schema
mysql -u root -p controle_pedidos < db_schema.sql
```

#### **3. Configurar CodeIgniter:**
```bash
# Copiar arquivo de configuração
cp application/config/database.example.php application/config/database.php

# Editar credenciais do banco em database.php
```

#### **4. Configurar Servidor Web:**
```bash
# Apache - habilitar mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Configurar DocumentRoot para a pasta do projeto
```

## 🎯 Como Usar

### **1. Acessar o Sistema:**
```
http://localhost/controle-pedidos/
```

### **2. Fluxo Principal:**

#### **📦 Gestão de Produtos:**
- Acesse: `http://localhost/controle-pedidos/produtos`
- Cadastre produtos com variações e estoque
- Edite e gerencie produtos existentes

#### **🛒 Carrinho de Compras:**
- Adicione produtos ao carrinho
- Controle quantidades individualmente
- Visualize cálculos automáticos de frete

#### **✅ Finalização:**
- Preencha dados pessoais
- CEP é preenchido automaticamente
- Aplique cupons de desconto
- Confirme o pedido

### **3. URLs Principais:**
```
/produtos           - Lista e gestão de produtos
/carrinho           - Carrinho de compras  
/carrinho/finalizar - Finalização do pedido
```

## 🎫 Sistema de Cupons

### **Criar Cupons via SQL:**
```sql
INSERT INTO cupons (codigo, desconto, validade, valor_minimo) VALUES
('DESCONTO10', 10.00, '2024-12-31', 50.00),
('FRETE15', 15.00, '2024-12-31', 100.00),
('PROMO20', 20.00, '2024-12-31', 150.00);
```

### **Regras de Frete:**
- **R$ 52,00 - R$ 166,59:** Frete R$ 15,00
- **Acima de R$ 200,00:** Frete Grátis
- **Outros valores:** Frete R$ 20,00

## 🔗 Webhook

### **Endpoint:**
```
POST /webhook/pedido
```

### **Payload:**
```json
{
    "pedido_id": 123,
    "status": "cancelado"
}
```

### **Status Aceitos:**
- `cancelado` - Remove o pedido
- `confirmado` - Atualiza status
- `enviado` - Atualiza status
- `entregue` - Atualiza status

## 📁 Estrutura do Projeto

```
controle-pedidos/
├── application/
│   ├── controllers/
│   │   ├── Produtos.php
│   │   ├── Carrinho.php
│   │   └── Webhook.php
│   ├── models/
│   │   ├── Produto_model.php
│   │   ├── Estoque_model.php
│   │   ├── Cupom_model.php
│   │   └── Pedido_model.php
│   ├── views/
│   │   ├── produtos_list.php
│   │   ├── produtos_form.php
│   │   ├── carrinho_view.php
│   │   └── finalizar_pedido.php
│   └── config/
├── system/
├── db_schema.sql          # ⭐ Queries para criar o banco
├── index.php
├── .htaccess
└── README.md
```

## 🐛 Solução de Problemas

### **Erro 404 nas URLs:**
- Verifique se o mod_rewrite está habilitado
- Confirme se o .htaccess está na raiz do projeto

### **Erro de Conexão com Banco:**
- Verifique as credenciais em `application/config/database.php`
- Certifique-se de que o MySQL está rodando
- Confirme se o banco `controle_pedidos` foi criado

### **CEP não funciona:**
- Verifique conexão com internet
- Teste a API: `https://viacep.com.br/ws/01310-100/json/`

### **E-mail não envia:**
- Configure SMTP em `application/config/email.php`
- Verifique credenciais do servidor de e-mail

## 🔧 Desenvolvimento

### **Ambiente de Desenvolvimento:**
```bash
# Habilitar debug
# Em application/config/config.php
$config['log_threshold'] = 4;

# Em index.php
define('ENVIRONMENT', 'development');
```

### **Logs:**
```bash
tail -f application/logs/log-*.php
```

## 📊 Banco de Dados

### **Tabelas Principais:**
- `produtos` - Informações dos produtos
- `variacoes` - Variações dos produtos
- `estoque` - Controle de estoque
- `cupons` - Cupons de desconto
- `pedidos` - Pedidos realizados
- `pedido_itens` - Itens dos pedidos

### **Relacionamentos:**
- Produtos → Variações (1:N)
- Produtos/Variações → Estoque (1:1)
- Pedidos → Pedido_itens (1:N)
- Produtos → Pedido_itens (N:N)

## 🎨 Customização

### **Cores e Temas:**
As cores principais podem ser alteradas nos arquivos CSS inline das views:
- Azul primário: `#0d6efd`
- Verde sucesso: `#198754`
- Vermelho perigo: `#dc3545`

### **Layout:**
- Bootstrap 5 classes para responsividade
- Gradientes CSS para visual moderno
- Ícones Bootstrap Icons

## 📝 Licença

Este projeto foi desenvolvido como teste técnico e está disponível para uso educacional.

## 👨‍💻 Desenvolvedor

Desenvolvido com ❤️ usando CodeIgniter 3 + Bootstrap 5

---

## ⚡ Quick Start

### 🐳 **Com Docker (Mais Rápido):**
```bash
# 1. Clone o projeto
git clone [URL_DO_REPOSITORIO]
cd controle-pedidos

# 2. Subir containers
docker-compose up -d

# 3. Instalar dependências
docker-compose exec app composer install

# 4. Importar banco (aguardar 30s para MySQL inicializar)
docker-compose exec db mysql -u root -proot controle_pedidos < db_schema.sql

# 5. Acessar o sistema
http://localhost:8081/produtos
```

### 💻 **Instalação Local:**
```bash
# 1. Clone o projeto
git clone [URL_DO_REPOSITORIO]
cd controle-pedidos

# 2. Instalar dependências
composer install

# 3. Configure o banco
mysql -u root -p
CREATE DATABASE controle_pedidos;
USE controle_pedidos;
SOURCE db_schema.sql;

# 4. Configure database.php
cp application/config/database.example.php application/config/database.php
# Edite as credenciais do banco

# 5. Acesse o sistema
http://localhost/controle-pedidos/produtos
```

**🎉 Pronto! Seu sistema está funcionando!**
>>>>>>> b2aaa3e (🎉 Initial commit: Sistema de E-commerce com Docker)
