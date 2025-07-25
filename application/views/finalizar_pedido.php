<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido</title>
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
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        .form-section {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        .order-summary {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 8px 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        .section-title {
            color: #0d6efd;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 1rem;
        }
    </style>
    <script>
    function buscarCepAutomatico(cep) {
        const mensagemDiv = document.getElementById('mensagem-cep');
        
        if (cep.length === 8) {
            // Limpar mensagem anterior
            mensagemDiv.innerHTML = '';
            
            fetch('https://viacep.com.br/ws/' + cep + '/json/')
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('endereco').value = data.logradouro + ', ' + (data.bairro || '') + ', ' + (data.localidade || '') + ' - ' + (data.uf || '');
                        mensagemDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle me-1"></i>CEP encontrado!</small>';
                    } else {
                        document.getElementById('endereco').value = '';
                        mensagemDiv.innerHTML = '<small class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>CEP não encontrado. Verifique o número digitado.</small>';
                    }
                })
                .catch(error => {
                    document.getElementById('endereco').value = '';
                    mensagemDiv.innerHTML = '<small class="text-warning"><i class="bi bi-wifi-off me-1"></i>Erro ao buscar CEP. Verifique sua conexão.</small>';
                });
        }
    }
    </script>
</head>
<body>
<div class="container mt-2">
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1 text-primary">✅ Finalizar Pedido</h1>
                <p class="text-muted mb-0">Preencha seus dados para concluir a compra</p>
            </div>
            <a href="<?php echo site_url('carrinho'); ?>" 
               class="btn btn-outline-primary cart-icon position-relative" 
               data-bs-toggle="tooltip" 
               data-bs-placement="left" 
               data-bs-title="Voltar ao carrinho">
                <i class="bi bi-cart3 fs-4"></i>
                <span class="visually-hidden">Voltar ao Carrinho</span>
            </a>
        </div>
    </div>
    
    <form method="post" action="<?php echo site_url('carrinho/finalizar'); ?>">
        <!-- Seção de Dados Pessoais e Endereço -->
        <div class="form-section">
            <!-- Dados Pessoais -->
            <h5 class="section-title">👤 Dados Pessoais</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label mb-1">Nome Completo</label>
                    <input type="text" name="cliente" class="form-control form-control-sm" placeholder="Digite seu nome completo" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label mb-1">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="seu@email.com" required>
                </div>
            </div>
            
            <!-- Endereço de Entrega -->
            <h5 class="section-title">📍 Endereço de Entrega</h5>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label mb-1">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control form-control-sm" maxlength="9" placeholder="00000-000" required>
                    <div id="mensagem-cep" class="mt-1"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-1">Endereço Completo</label>
                    <input type="text" name="endereco" id="endereco" class="form-control form-control-sm" placeholder="Rua, bairro, cidade - UF" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Número</label>
                    <input type="text" name="numero" id="numero" class="form-control form-control-sm" placeholder="número" required>
                </div>
            </div>
        </div>

        <!-- Seção de Cupom -->
        <div class="form-section">
            <h5 class="section-title">🎫 Cupom de Desconto</h5>
            <div class="col-md-8 mb-0">
                <label class="form-label mb-1">Código do Cupom (opcional)</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="cupom" id="cupom" class="form-control" placeholder="Digite o código do cupom">
                    <button type="button" class="btn btn-outline-success" id="btn-aplicar-cupom">
                        <i class="bi bi-check-circle me-1"></i>Aplicar
                    </button>
                </div>
                <div id="mensagem-cupom" class="mt-1"></div>
            </div>
        </div>
        <!-- Seção do Resumo do Pedido -->
        <div class="order-summary">
            <h5 class="section-title">📋 Resumo do Pedido</h5>
            <div class="table-responsive">
                <table class="table table-hover" id="tabela-resumo">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($carrinho as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome']) ?></td>
                            <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                            <td style="padding-left: 38px;"><span class="badge bg-primary"><?= $item['quantidade'] ?></span></td>
                            <td><strong>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            
            <!-- Resumo de Totais em Tabela -->
            <div class="table-responsive mt-2">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Subtotal:</strong></td>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>R$ <span id="subtotal-span"><?= number_format($subtotal, 2, ',', '.') ?></span></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Frete:</strong></td>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>R$ <span id="frete-span"><?= number_format($frete, 2, ',', '.') ?></span></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Desconto:</strong></td>
                            <td></td>
                            <td></td>
                            <td class="text-end text-success"><strong>- R$ <span id="desconto-span">0,00</span></strong></td>
                        </tr>
                        <tr class="table-success">
                            <td><strong class="fs-5">Total:</strong></td>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong class="fs-5 text-success">R$ <span id="total-span"><?= number_format($total, 2, ',', '.') ?></span></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="d-flex gap-2 justify-content-center mt-2 mb-2">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-circle me-2"></i>Confirmar Pedido
            </button>
            <a href="<?php echo site_url('carrinho'); ?>" class="btn btn-outline-secondary px-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar ao Carrinho
            </a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('btn-aplicar-cupom').onclick = function() {
    var cupom = document.getElementById('cupom').value;
    var subtotal = "<?= $subtotal ?>";
    var mensagemDiv = document.getElementById('mensagem-cupom');
    fetch('<?= site_url('carrinho/validar_cupom') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'cupom=' + encodeURIComponent(cupom) + '&subtotal=' + encodeURIComponent(subtotal)
    })
    .then(response => response.json())
    .then(data => {
        mensagemDiv.innerHTML = data.mensagem;
        if (data.status === 'ok') {
            document.getElementById('desconto-span').innerText = parseFloat(data.desconto).toLocaleString('pt-BR', {minimumFractionDigits: 2});
            var total = parseFloat(subtotal) + parseFloat(document.getElementById('frete-span').innerText.replace('.', '').replace(',', '.')) - parseFloat(data.desconto);
            document.getElementById('total-span').innerText = total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        } else {
            document.getElementById('desconto-span').innerText = '0,00';
            var total = parseFloat(subtotal) + parseFloat(document.getElementById('frete-span').innerText.replace('.', '').replace(',', '.'));
            document.getElementById('total-span').innerText = total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        }
    });
};

// Inicializar tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Busca automática de CEP
document.getElementById('cep').addEventListener('input', function(e) {
    let cep = e.target.value.replace(/\D/g, '');
    
    // Formatar CEP com hífen
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
        e.target.value = cep;
    }
    
    // Buscar CEP quando tiver 8 dígitos
    if (cep.replace('-', '').length === 8) {
        buscarCepAutomatico(cep.replace('-', ''));
    }
});
</script>
</body>
</html> 