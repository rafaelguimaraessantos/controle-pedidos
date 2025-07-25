<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-primary">
            <i class="bi bi-receipt me-2"></i>
            Pedidos
        </h2>
        <p class="text-muted mb-0">Gerencie todos os pedidos do sistema</p>
    </div>
</div>

<!-- Tabela de pedidos -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $pedido->id ?></span></td>
                            <td>
                                <strong><?= htmlspecialchars($pedido->cliente) ?></strong>
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    R$ <?= number_format($pedido->total, 2, ',', '.') ?>
                                </span>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?= date('d/m/Y H:i', strtotime($pedido->created_at)) ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo site_url('pedidos/show/'.$pedido->id); ?>" 
                                   class="btn btn-sm btn-outline-info" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-title="Ver detalhes">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-receipt fs-1 d-block mb-3"></i>
                                <h5>Nenhum pedido encontrado</h5>
                                <p>Quando houver pedidos, eles aparecerão aqui.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<?php if (!empty($pedidos)): ?>
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total de Pedidos</h6>
                        <h3 class="mb-0"><?= count($pedidos) ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-receipt fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Valor Total</h6>
                        <h3 class="mb-0">
                            R$ <?= number_format(array_sum(array_map(function($p) { return $p->total; }, $pedidos)), 2, ',', '.') ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pedidos Pendentes</h6>
                        <h3 class="mb-0">
                            <?= count(array_filter($pedidos, function($p) { return strtolower($p->status) == 'pendente'; })) ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pedidos Aprovados</h6>
                        <h3 class="mb-0">
                            <?= count(array_filter($pedidos, function($p) { return strtolower($p->status) == 'aprovado'; })) ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 