<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-primary">
            <i class="bi bi-receipt me-2"></i>
            Pedido #<?= $pedido->id ?>
        </h2>
        <p class="text-muted mb-0">Detalhes completos do pedido</p>
    </div>
    <a href="<?php echo site_url('pedidos'); ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>
        Voltar aos Pedidos
    </a>
</div>

<!-- Informações do Cliente -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person me-2"></i>
                    Informações do Cliente
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong> <?= htmlspecialchars($pedido->cliente) ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($pedido->email) ?></p>
                <p><strong>Endereço:</strong> <?= htmlspecialchars($pedido->endereco) ?></p>
                <p><strong>CEP:</strong> <?= htmlspecialchars($pedido->cep) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Informações do Pedido
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong> 
                    <?php 
                    $status_class = 'secondary';
                    switch(strtolower($pedido->status)) {
                        case 'pendente':
                            $status_class = 'warning';
                            break;
                        case 'aprovado':
                            $status_class = 'success';
                            break;
                        case 'cancelado':
                            $status_class = 'danger';
                            break;
                        case 'entregue':
                            $status_class = 'info';
                            break;
                    }
                    ?>
                    <span class="badge bg-<?= $status_class ?>"><?= ucfirst($pedido->status) ?></span>
                </p>
                <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido->created_at)) ?></p>
                <p><strong>Total:</strong> 
                    <span class="fw-bold text-success fs-5">
                        R$ <?= number_format($pedido->total, 2, ',', '.') ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Itens do Pedido -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Itens do Pedido
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Variação</th>
                        <th scope="col" class="text-center">Quantidade</th>
                        <th scope="col" class="text-end">Preço Unit.</th>
                        <th scope="col" class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($item->produto_id ? ($CI->Produto_model->get($item->produto_id)->nome) : '-') ?></strong>
                        </td>
                        <td>
                            <?php if ($item->variacao_id): ?>
                                <span class="badge bg-info"><?= htmlspecialchars($CI->Variacao_model->get($item->variacao_id)->nome) ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary"><?= $item->quantidade ?></span>
                        </td>
                        <td class="text-end">
                            R$ <?= number_format($item->preco, 2, ',', '.') ?>
                        </td>
                        <td class="text-end">
                            <strong>R$ <?= number_format($item->preco * $item->quantidade, 2, ',', '.') ?></strong>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end">
                            <strong class="text-success fs-5">
                                R$ <?= number_format($pedido->total, 2, ',', '.') ?>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> 