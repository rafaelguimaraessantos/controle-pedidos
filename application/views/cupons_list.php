<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cupons</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Cupons</h1>
    <a href="<?php echo site_url('cupons/create'); ?>" class="btn btn-primary mb-3">Cadastrar Cupom</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Validade</th>
                <th>Valor Mínimo</th>
                <th>Desconto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($cupons)): ?>
            <?php foreach ($cupons as $cupom): ?>
                <tr>
                    <td><?= htmlspecialchars($cupom->codigo) ?></td>
                    <td><?= $cupom->validade ?></td>
                    <td>R$ <?= number_format($cupom->valor_minimo, 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($cupom->desconto, 2, ',', '.') ?></td>
                    <td>
                        <a href="<?php echo site_url('cupons/edit/'.$cupom->id); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?php echo site_url('cupons/delete/'.$cupom->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Nenhum cupom cadastrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html> 