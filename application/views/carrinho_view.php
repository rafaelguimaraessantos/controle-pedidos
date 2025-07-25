<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .products-icon {
            transition: all 0.3s ease;
            border-radius: 50px;
            padding: 12px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .products-icon:hover {
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
        .cart-summary {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #fff3e0 0%, #fce4ec 100%);
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1 text-primary">🛒 Carrinho de Compras</h1>
                <p class="text-muted mb-0">Revise seus itens antes de finalizar</p>
            </div>
            <a href="<?php echo site_url('produtos'); ?>" 
               class="btn btn-outline-primary products-icon position-relative" 
               data-bs-toggle="tooltip" 
               data-bs-placement="left" 
               data-bs-title="Ver lista de produtos">
                <i class="bi bi-list-ul fs-4"></i>
                <span class="visually-hidden">Ver Produtos</span>
            </a>
        </div>
    </div>
    <?php if (!empty($carrinho)): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($carrinho as $key => $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nome']) ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td>
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="<?php echo site_url('carrinho/diminuir/'.$key); ?>" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-dash"></i>
                        </a>
                        <span class="badge bg-primary mx-2"><?= $item['quantidade'] ?></span>
                        <a href="<?php echo site_url('carrinho/aumentar/'.$key); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="bi bi-plus"></i>
                        </a>
                    </div>
                </td>
                <td>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalRemover" data-item-key="<?= $key ?>" data-item-nome="<?= htmlspecialchars($item['nome']) ?>">
                        <i class="bi bi-trash me-1"></i>Remover Tudo
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="cart-summary">
        <h5 class="text-primary mb-3">💰 Resumo do Pedido</h5>
        <div class="row">
            <div class="col-md-8">
                <p class="mb-2"><strong>Subtotal:</strong> R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
                <p class="mb-2"><strong>Frete:</strong> R$ <?= number_format($frete, 2, ',', '.') ?></p>
                <hr>
                <h5 class="text-success"><strong>Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?></h5>
            </div>
        </div>
    </div>
    <a href="<?php echo site_url('carrinho/finalizar'); ?>" class="btn btn-success">Finalizar Compra</a>
    <a href="<?php echo site_url('produtos'); ?>" class="btn btn-secondary">Continuar Comprando</a>
    <?php else: ?>
        <div class="empty-cart">
            <i class="bi bi-cart-x fs-1 text-muted mb-3"></i>
            <h3 class="text-muted mb-3">Seu carrinho está vazio</h3>
            <p class="text-muted mb-4">Que tal explorar nossos produtos e adicionar alguns itens?</p>
            <a href="<?php echo site_url('produtos'); ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-grid3x3-gap-fill me-2"></i>Ver Produtos
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Confirmação de Remoção -->
<div class="modal fade" id="modalRemover" tabindex="-1" aria-labelledby="modalRemoverLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalRemoverLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar Remoção
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-trash fs-1 text-danger"></i>
                </div>
                <h6 class="mb-3">Tem certeza que deseja remover este item?</h6>
                <p class="text-muted mb-0">
                    <strong id="nomeItem"></strong>
                </p>
                <small class="text-muted">Esta ação não pode ser desfeita.</small>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <a href="#" id="btnConfirmarRemocao" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Sim, Remover
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Configurar modal de remoção
    const modalRemover = document.getElementById('modalRemover');
    modalRemover.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const itemKey = button.getAttribute('data-item-key');
        const itemNome = button.getAttribute('data-item-nome');
        
        // Atualizar conteúdo da modal
        document.getElementById('nomeItem').textContent = itemNome;
        document.getElementById('btnConfirmarRemocao').href = '<?php echo site_url('carrinho/remover/'); ?>' + itemKey;
    });
</script>
</body>
</html> 