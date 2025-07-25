
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 text-primary">
                <i class="bi bi-ticket-perforated me-2"></i>
                Cupons de Desconto
            </h2>
            <p class="text-muted mb-0">Gerencie os cupons de desconto do sistema</p>
        </div>
    </div>

    <!-- Botão de adicionar cupom -->
    <div class="mb-4">
        <a href="<?php echo site_url('cupons/create'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Novo Cupom
        </a>
    </div>

    <!-- Tabela de cupons -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Desconto</th>
                            <th scope="col">Valor Mínimo</th>
                            <th scope="col">Validade</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cupons)): ?>
                        <?php foreach ($cupons as $cupom): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-primary fs-6"><?= htmlspecialchars($cupom->codigo) ?></span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        <?= $cupom->desconto ?>%
                                    </span>
                                </td>
                                <td>
                                    R$ <?= number_format($cupom->valor_minimo, 2, ',', '.') ?>
                                </td>
                                <td>
                                    <?php 
                                    $validade = new DateTime($cupom->validade);
                                    $hoje = new DateTime();
                                    $status = $validade >= $hoje ? 'success' : 'danger';
                                    $texto = $validade >= $hoje ? 'Válido' : 'Expirado';
                                    ?>
                                    <span class="badge bg-<?= $status ?>">
                                        <?= $validade->format('d/m/Y') ?>
                                    </span>
                                    <br><small class="text-muted"><?= $texto ?></small>
                                </td>
                                <td>
                                    <?php if ($validade >= $hoje): ?>
                                        <span class="badge bg-success">Ativo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Expirado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo site_url('cupons/edit/'.$cupom->id); ?>" 
                                           class="btn btn-sm btn-outline-warning" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-title="Editar cupom">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?php echo site_url('cupons/delete/'.$cupom->id); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirmDelete('Tem certeza que deseja excluir este cupom?')"
                                           data-bs-toggle="tooltip" 
                                           data-bs-title="Excluir cupom">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-ticket-perforated fs-1 d-block mb-3"></i>
                                    <h5>Nenhum cupom cadastrado</h5>
                                    <p>Comece criando seu primeiro cupom de desconto.</p>
                                    <a href="<?php echo site_url('cupons/create'); ?>" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Novo Cupom
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
    <?php if (!empty($cupons)): ?>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total de Cupons</h6>
                            <h3 class="mb-0"><?= count($cupons) ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-ticket-perforated fs-1"></i>
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
                            <h6 class="card-title">Cupons Ativos</h6>
                            <h3 class="mb-0">
                                <?php 
                                $hoje = new DateTime();
                                echo count(array_filter($cupons, function($c) use ($hoje) { 
                                    return new DateTime($c->validade) >= $hoje; 
                                }));
                                ?>
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
                            <h6 class="card-title">Cupons Expirados</h6>
                            <h3 class="mb-0">
                                <?php 
                                $hoje = new DateTime();
                                echo count(array_filter($cupons, function($c) use ($hoje) { 
                                    return new DateTime($c->validade) < $hoje; 
                                }));
                                ?>
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
                            <h6 class="card-title">Desconto Médio</h6>
                            <h3 class="mb-0">
                                <?= number_format(array_sum(array_map(function($c) { return $c->desconto; }, $cupons)) / count($cupons), 1) ?>%
                            </h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-percent fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?> 