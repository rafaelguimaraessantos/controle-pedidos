<!-- Header com botão do carrinho -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-primary">
            <i class="bi bi-box me-2"></i>
            Lista de Produtos
        </h2>
        <p class="text-muted mb-0">Gerencie todos os produtos do sistema</p>
    </div>
    <a href="<?php echo site_url('carrinho'); ?>" 
       class="btn btn-outline-primary position-relative" 
       data-bs-toggle="tooltip" 
       data-bs-placement="left" 
       data-bs-title="Ir para carrinho">
        <i class="bi bi-cart3 fs-4"></i>
        <?php if (isset($total_itens_carrinho) && $total_itens_carrinho > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $total_itens_carrinho ?>
            </span>
        <?php endif; ?>
    </a>
</div>

<!-- Botão de adicionar produto -->
<div class="mb-4">
    <a href="<?php echo site_url('produtos/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Cadastrar Produto
    </a>
</div>

<!-- Tabela de produtos -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Estoque</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $produto->id ?></span></td>
                            <td>
                                <strong><?= htmlspecialchars($produto->nome) ?></strong>
                                <?php if (!empty($produto->descricao)): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($produto->descricao) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    R$ <?= number_format($produto->preco, 2, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($produto->estoque > 0): ?>
                                    <span class="badge bg-success"><?= $produto->estoque ?> unidades</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Sem estoque</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?php echo site_url('produtos/edit/'.$produto->id); ?>" 
                                       class="btn m-2 btn-sm btn-outline-warning" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Editar produto">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo site_url('carrinho/adicionar/'.$produto->id); ?>" 
                                       class="btn m-2 btn-sm btn-outline-success" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Adicionar ao carrinho">
                                        <i class="bi bi-cart-plus"></i>
                                    </a>
                                    <a href="<?php echo site_url('produtos/delete/'.$produto->id); ?>" 
                                       class="btn m-2 btn-sm btn-outline-danger" 
                                       onclick="return confirmDelete('Tem certeza que deseja excluir este produto?')"
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Excluir produto">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-box fs-1 d-block mb-3"></i>
                                <h5>Nenhum produto cadastrado</h5>
                                <p>Comece adicionando seu primeiro produto ao sistema.</p>
                                <a href="<?php echo site_url('produtos/create'); ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Cadastrar Produto
                                </a>
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
<?php if (!empty($produtos)): ?>
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total de Produtos</h6>
                        <h3 class="mb-0"><?= count($produtos) ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box fs-1"></i>
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
                        <h6 class="card-title">Com Estoque</h6>
                        <h3 class="mb-0">
                            <?= count(array_filter($produtos, function($p) { return $p->estoque > 0; })) ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1"></i>
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
                        <h6 class="card-title">Sem Estoque</h6>
                        <h3 class="mb-0">
                            <?= count(array_filter($produtos, function($p) { return $p->estoque <= 0; })) ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle fs-1"></i>
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
                        <h6 class="card-title">Valor Total</h6>
                        <h3 class="mb-0">
                            R$ <?= number_format(array_sum(array_map(function($p) { return $p->preco * $p->estoque; }, $produtos)), 2, ',', '.') ?>
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 