<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Pedidos</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Status</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido->id ?></td>
                    <td><?= htmlspecialchars($pedido->cliente) ?></td>
                    <td>R$ <?= number_format($pedido->total, 2, ',', '.') ?></td>
                    <td><?= $pedido->status ?></td>
                    <td><?= $pedido->created_at ?></td>
                    <td>
                        <a href="<?php echo site_url('pedidos/show/'.$pedido->id); ?>" class="btn btn-sm btn-info">Detalhar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Nenhum pedido encontrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html> 