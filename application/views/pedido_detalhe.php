<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhe do Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Detalhe do Pedido #<?= $pedido->id ?></h1>
    <div class="mb-3">
        <strong>Cliente:</strong> <?= htmlspecialchars($pedido->cliente) ?><br>
        <strong>E-mail:</strong> <?= htmlspecialchars($pedido->email) ?><br>
        <strong>Endereço:</strong> <?= htmlspecialchars($pedido->endereco) ?><br>
        <strong>CEP:</strong> <?= htmlspecialchars($pedido->cep) ?><br>
        <strong>Status:</strong> <?= $pedido->status ?><br>
        <strong>Total:</strong> R$ <?= number_format($pedido->total, 2, ',', '.') ?><br>
        <strong>Data:</strong> <?= $pedido->created_at ?>
    </div>
    <h4>Itens do Pedido</h4>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Variação</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($itens as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item->produto_id ? ($this->Produto_model->get($item->produto_id)->nome) : '-') ?></td>
                <td><?= htmlspecialchars($item->variacao_id ? ($this->Variacao_model->get($item->variacao_id)->nome) : '-') ?></td>
                <td><?= $item->quantidade ?></td>
                <td>R$ <?= number_format($item->preco, 2, ',', '.') ?></td>
                <td>R$ <?= number_format($item->preco * $item->quantidade, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?php echo site_url('pedidos'); ?>" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html> 