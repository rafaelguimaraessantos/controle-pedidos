<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .cart-icon {
            transition: all 0.3s ease;
            border-radius: 50px;
            padding: 12px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .cart-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        .header-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        .cart-icon:hover .cart-badge {
            background: #fff;
            color: #0d6efd;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    <script>
    // Função para adicionar variação
    function addVariacao() {
        const container = document.getElementById('variacoes-container');
        const idx = container.children.length;
        const html = `<div class='row mb-2 variacao-item'>
            <div class='col-md-4'><input type='text' name='variacoes[${idx}][nome]' class='form-control' placeholder='Nome da Variação' required></div>
            <div class='col-md-3'><input type='number' step='0.01' name='variacoes[${idx}][preco]' class='form-control' placeholder='Preço'></div>
            <div class='col-md-3'><input type='number' name='variacoes[${idx}][estoque]' class='form-control' placeholder='Estoque' required></div>
            <div class='col-md-2'><button type='button' class='btn btn-danger' onclick='this.closest(".variacao-item").remove()'>Remover</button></div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    </script>
</head>
<body>
<div class="container mt-4">
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1 text-primary">
                    <?php if (isset($produto)): ?>
                        ✏️ Editar Produto
                    <?php else: ?>
                        ➕ Cadastrar Produto
                    <?php endif; ?>
                </h1>
                <p class="text-muted mb-0">
                    <?php if (isset($produto)): ?>
                        Atualize as informações do produto
                    <?php else: ?>
                        Adicione um novo produto ao catálogo
                    <?php endif; ?>
                </p>
            </div>
            <a href="<?php echo site_url('carrinho'); ?>" 
               class="btn btn-outline-primary cart-icon position-relative" 
               data-bs-toggle="tooltip" 
               data-bs-placement="left" 
               data-bs-title="Ir para carrinho">
                <i class="bi bi-cart3 fs-4"></i>
                <?php if (isset($total_itens_carrinho) && $total_itens_carrinho > 0): ?>
                    <span class="cart-badge"><?= $total_itens_carrinho ?></span>
                <?php endif; ?>
                <span class="visually-hidden">Ver Carrinho</span>
            </a>
        </div>
    </div>
    <form method="post" action="<?php echo isset($produto) ? site_url('produtos/update/'.$produto->id) : site_url('produtos/store'); ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($produto) ? htmlspecialchars($produto->nome) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?php echo isset($produto) ? $produto->preco : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao"><?php echo isset($produto) ? htmlspecialchars($produto->descricao) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Variações (opcional)</label>
            <div id="variacoes-container">
                <?php if (isset($variacoes) && $variacoes): foreach ($variacoes as $i => $v): ?>
                <div class="row mb-2 variacao-item">
                    <div class="col-md-4"><input type="text" name="variacoes[<?= $i ?>][nome]" class="form-control" value="<?= htmlspecialchars($v->nome) ?>" placeholder="Nome da Variação" required></div>
                    <div class="col-md-3"><input type="number" step="0.01" name="variacoes[<?= $i ?>][preco]" class="form-control" value="<?= $v->preco ?>" placeholder="Preço"></div>
                    <div class="col-md-3"><input type="number" name="variacoes[<?= $i ?>][estoque]" class="form-control" value="<?= $v->estoque ?? '' ?>" placeholder="Estoque" required></div>
                    <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.variacao-item').remove()">Remover</button></div>
                </div>
                <?php endforeach; endif; ?>
            </div>
            <button type="button" class="btn btn-secondary mt-2" onclick="addVariacao()">Adicionar Variação</button>
        </div>
        <div class="mb-3">
            <label for="estoque" class="form-label">Estoque (produto simples)</label>
            <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo isset($estoque) ? $estoque : ''; ?>" placeholder="Preencha se não houver variações">
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?php echo site_url('produtos'); ?>" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
</body>
</html> 