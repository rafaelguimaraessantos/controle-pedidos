<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
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
</head>
<body>
<div class="container mt-4">
    <?php $CI =& get_instance(); ?>
    <?php if ($CI->session->flashdata('sucesso')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-sucesso">
            <?= $CI->session->flashdata('sucesso') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        <script>
        setTimeout(function() {
            var alert = document.getElementById('alert-sucesso');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
        </script>
    <?php endif; ?>
    <?php if ($CI->session->flashdata('erro')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-erro">
            <?= $CI->session->flashdata('erro') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        <script>
        setTimeout(function() {
            var alert = document.getElementById('alert-erro');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
        </script>
    <?php endif; ?>
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1 text-primary">🛍️ Produtos</h1>
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
    <a href="<?php echo site_url('produtos/create'); ?>" class="btn btn-primary mb-3">Cadastrar Produto</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto->id ?></td>
                    <td><?= htmlspecialchars($produto->nome) ?></td>
                    <td>R$ <?= number_format($produto->preco, 2, ',', '.') ?></td>
                    <td><?= $produto->estoque ?></td>
                    <td>
                        <a href="<?php echo site_url('produtos/edit/'.$produto->id); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?php echo site_url('produtos/delete/'.$produto->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                        <a href="<?php echo site_url('carrinho/adicionar/'.$produto->id); ?>" class="btn btn-sm btn-success">Comprar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Nenhum produto cadastrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
</body>
</html> 