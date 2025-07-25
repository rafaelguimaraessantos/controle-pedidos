# Layout System - Sistema de Controle de Pedidos

## Visão Geral

Este sistema utiliza um layout unificado com Bootstrap 5 para todas as páginas, proporcionando uma experiência consistente e moderna.

## Estrutura de Arquivos

```
application/views/layout/
├── main.php          # Layout principal com Bootstrap 5
└── README.md         # Esta documentação

application/helpers/
└── layout_helper.php # Helper para facilitar o uso do layout
```

## Como Usar o Layout

### 1. Nas Controllers

Substitua o uso direto de `$this->load->view()` pela função `render_page()`:

```php
// ❌ Antes
$this->load->view('minha_view', $data);

// ✅ Depois
render_page('minha_view', $data, 'Título da Página', 'Subtítulo da página', $breadcrumb);
```

### 2. Exemplo Completo de Controller

```php
<?php
class MinhaController extends CI_Controller {
    
    public function index() {
        $data['items'] = $this->MeuModel->get_all();
        
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Minha Seção')
        );
        
        render_page('minha_view', $data, 'Minha Seção', 'Descrição da seção', $breadcrumb);
    }
    
    public function create() {
        // Breadcrumb com navegação
        $breadcrumb = array(
            add_breadcrumb_item('Minha Seção', base_url('minha-secao')),
            add_breadcrumb_item('Novo Item')
        );
        
        render_page('minha_form', array(), 'Novo Item', 'Criar novo item', $breadcrumb);
    }
}
```

### 3. Nas Views

As views agora devem conter apenas o conteúdo, sem HTML, head, body, etc.:

```php
<!-- ✅ Correto - Apenas o conteúdo -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Meu Conteúdo</h5>
        <p class="card-text">Conteúdo da página...</p>
    </div>
</div>

<!-- ❌ Incorreto - Não incluir HTML completo -->
<!DOCTYPE html>
<html>
<head>...</head>
<body>...</body>
</html>
```

## Recursos do Layout

### 1. Menu de Navegação

O layout inclui automaticamente um menu com as 4 seções principais:
- **Produtos** (`/produtos`)
- **Pedidos** (`/pedidos`) 
- **Cupons** (`/cupons`)
- **Carrinho** (`/carrinho`)

### 2. Breadcrumb

Para adicionar breadcrumb, use as funções helper:

```php
$breadcrumb = array(
    add_breadcrumb_item('Início', base_url()),
    add_breadcrumb_item('Produtos', base_url('produtos')),
    add_breadcrumb_item('Editar') // Último item sem URL
);
```

### 3. Flash Messages

O layout suporta automaticamente mensagens flash:

```php
// Na controller
$this->session->set_flashdata('success', 'Operação realizada com sucesso!');
$this->session->set_flashdata('error', 'Erro na operação!');
$this->session->set_flashdata('warning', 'Atenção!');
$this->session->set_flashdata('info', 'Informação importante.');
```

### 4. Títulos e Subtítulos

```php
render_page('view', $data, 'Título Principal', 'Subtítulo explicativo', $breadcrumb);
```

## Bootstrap 5 Features

O layout inclui:

- **Bootstrap 5.3.0** (CSS e JS)
- **Bootstrap Icons 1.10.0**
- **Tooltips** automáticos
- **Alerts** com auto-hide
- **Responsive design**
- **Dark navbar** com dropdown de usuário

## JavaScript Incluído

O layout inclui JavaScript para:

- Auto-hide de alerts após 5 segundos
- Confirmação de exclusão (`confirmDelete()`)
- Inicialização automática de tooltips

## Personalização

### CSS Customizado

Adicione estilos customizados no arquivo `main.php`:

```css
<style>
    /* Seus estilos aqui */
    .minha-classe {
        color: #007bff;
    }
</style>
```

### JavaScript Customizado

Adicione scripts no final do arquivo `main.php`:

```javascript
<script>
    // Seus scripts aqui
    function minhaFuncao() {
        // código...
    }
</script>
```

## Migração de Views Existentes

Para migrar uma view existente:

1. **Remova** todo o HTML estrutural (DOCTYPE, html, head, body)
2. **Remova** links para Bootstrap (já incluídos no layout)
3. **Mantenha** apenas o conteúdo da página
4. **Atualize** a controller para usar `render_page()`

### Exemplo de Migração

```php
// ❌ Antes
<!DOCTYPE html>
<html>
<head>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Minha Página</h1>
        <p>Conteúdo...</p>
    </div>
</body>
</html>

// ✅ Depois
<h1>Minha Página</h1>
<p>Conteúdo...</p>
```

## Troubleshooting

### Problema: View não carrega
**Solução:** Verifique se o helper `layout` está carregado no `autoload.php`

### Problema: Bootstrap não funciona
**Solução:** O Bootstrap está incluído via CDN no layout principal

### Problema: Menu não destaca página atual
**Solução:** O menu usa `$this->uri->segment(1)` para detectar a página atual 