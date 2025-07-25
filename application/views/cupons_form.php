<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($cupom) ? 'Editar Cupom' : 'Cadastrar Cupom'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1><?php echo isset($cupom) ? 'Editar Cupom' : 'Cadastrar Cupom'; ?></h1>
    <form method="post" action="<?php echo isset($cupom) ? site_url('cupons/update/'.$cupom->id) : site_url('cupons/store'); ?>">
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo isset($cupom) ? htmlspecialchars($cupom->codigo) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Validade</label>
            <input type="date" name="validade" class="form-control" value="<?php echo isset($cupom) ? $cupom->validade : ''; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Valor Mínimo</label>
            <input type="number" step="0.01" name="valor_minimo" class="form-control" value="<?php echo isset($cupom) ? $cupom->valor_minimo : '0.00'; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Desconto</label>
            <input type="number" step="0.01" name="desconto" class="form-control" value="<?php echo isset($cupom) ? $cupom->desconto : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?php echo site_url('cupons'); ?>" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html> 