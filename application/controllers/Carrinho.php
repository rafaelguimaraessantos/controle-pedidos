<?php
class Carrinho extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Variacao_model');
        $this->load->model('Estoque_model');
        $this->load->model('Cupom_model');
        $this->load->model('Pedido_model');
        $this->load->model('Pedido_itens_model');
        $this->load->helper('url');
    }
    
    public function index() {
        $carrinho = $this->session->userdata('carrinho') ?: [];
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        // Regras de frete
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal > 200) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }
        $total = $subtotal + $frete;
        $data = [
            'carrinho' => $carrinho,
            'subtotal' => $subtotal,
            'frete' => $frete,
            'total' => $total
        ];
        
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Carrinho')
        );
        
        render_page('carrinho_view', $data, 'Carrinho de Compras', 'Gerencie os itens do seu carrinho', $breadcrumb);
    }
    public function adicionar($produto_id) {
        $produto = $this->Produto_model->get($produto_id);
        $variacoes = $this->Variacao_model->get_by_produto($produto_id);
        if (!$produto) {
            show_404();
        }
        if ($variacoes) {
            // Adiciona a primeira variação disponível
            $variacao = $variacoes[0];
            $estoque = $this->Estoque_model->get_by_variacao($variacao->id);
            if (!$estoque || $estoque->quantidade < 1) {
                $this->session->set_flashdata('erro', 'Estoque insuficiente!');
                redirect('produtos');
            }
            $carrinho = $this->session->userdata('carrinho') ?: [];
            $key = 'var_' . $variacao->id;
            if (isset($carrinho[$key])) {
                if ($carrinho[$key]['quantidade'] < $estoque->quantidade) {
                    $carrinho[$key]['quantidade']++;
                } else {
                    $this->session->set_flashdata('erro', 'Estoque insuficiente!');
                    redirect('produtos');
                }
            } else {
                $carrinho[$key] = [
                    'produto_id' => $produto->id,
                    'variacao_id' => $variacao->id,
                    'nome' => $produto->nome . ' - ' . $variacao->nome,
                    'preco' => $variacao->preco > 0 ? $variacao->preco : $produto->preco,
                    'quantidade' => 1
                ];
            }
            $this->session->set_userdata('carrinho', $carrinho);
            redirect('carrinho');
        } else {
            // Produto simples
            $estoque = $this->Estoque_model->get_by_produto($produto_id);
            if (!$estoque || $estoque->quantidade < 1) {
                $this->session->set_flashdata('erro', 'Estoque insuficiente!');
                redirect('produtos');
            }
            $carrinho = $this->session->userdata('carrinho') ?: [];
            $key = 'prod_' . $produto->id;
            if (isset($carrinho[$key])) {
                if ($carrinho[$key]['quantidade'] < $estoque->quantidade) {
                    $carrinho[$key]['quantidade']++;
                } else {
                    $this->session->set_flashdata('erro', 'Estoque insuficiente!');
                    redirect('produtos');
                }
            } else {
                $carrinho[$key] = [
                    'produto_id' => $produto->id,
                    'nome' => $produto->nome,
                    'preco' => $produto->preco,
                    'quantidade' => 1
                ];
            }
            $this->session->set_userdata('carrinho', $carrinho);
            redirect('carrinho');
        }
    }
    public function remover($key) {
        $carrinho = $this->session->userdata('carrinho') ?: [];
        if (isset($carrinho[$key])) {
            unset($carrinho[$key]);
            $this->session->set_userdata('carrinho', $carrinho);
        }
        redirect('carrinho');
    }

    public function aumentar($key) {
        $carrinho = $this->session->userdata('carrinho') ?: [];
        if (isset($carrinho[$key])) {
            // Verificar estoque disponível
            $item = $carrinho[$key];
            if (isset($item['variacao_id'])) {
                $estoque = $this->Estoque_model->get_by_variacao($item['variacao_id']);
            } else {
                $estoque = $this->Estoque_model->get_by_produto($item['produto_id']);
            }
            
            if ($estoque && $item['quantidade'] < $estoque->quantidade) {
                $carrinho[$key]['quantidade']++;
                $this->session->set_userdata('carrinho', $carrinho);
                $this->session->set_flashdata('sucesso', 'Quantidade aumentada!');
            } else {
                $this->session->set_flashdata('erro', 'Estoque insuficiente!');
            }
        }
        redirect('carrinho');
    }

    public function diminuir($key) {
        $carrinho = $this->session->userdata('carrinho') ?: [];
        if (isset($carrinho[$key])) {
            if ($carrinho[$key]['quantidade'] > 1) {
                $carrinho[$key]['quantidade']--;
                $this->session->set_userdata('carrinho', $carrinho);
                $this->session->set_flashdata('sucesso', 'Quantidade diminuída!');
            } else {
                // Se quantidade for 1, remove o item completamente
                unset($carrinho[$key]);
                $this->session->set_flashdata('sucesso', 'Item removido do carrinho!');
            }
            $this->session->set_userdata('carrinho', $carrinho);
        }
        redirect('carrinho');
    }
    public function finalizar() {
        $carrinho = $this->session->userdata('carrinho') ?: [];
        if (empty($carrinho)) {
            redirect('carrinho');
        }
        if ($this->input->method() === 'get') {
            // Exibe formulário de finalização
            $subtotal = 0;
            foreach ($carrinho as $item) {
                $subtotal += $item['preco'] * $item['quantidade'];
            }
            if ($subtotal >= 52 && $subtotal <= 166.59) {
                $frete = 15.00;
            } elseif ($subtotal > 200) {
                $frete = 0.00;
            } else {
                $frete = 20.00;
            }
            $total = $subtotal + $frete;
            $data = [
                'carrinho' => $carrinho,
                'subtotal' => $subtotal,
                'frete' => $frete,
                'total' => $total
            ];
            
            // Breadcrumb
            $breadcrumb = array(
                add_breadcrumb_item('Carrinho', base_url('carrinho')),
                add_breadcrumb_item('Finalizar Pedido')
            );
            
            render_page('finalizar_pedido', $data, 'Finalizar Pedido', 'Complete seus dados para finalizar a compra', $breadcrumb);
            return;
        }
        // POST: processa finalização
        $cliente = $this->input->post('cliente');
        $email = $this->input->post('email');
        $endereco = $this->input->post('endereco');
        $cep = $this->input->post('cep');
        $cupom_codigo = $this->input->post('cupom');
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal > 200) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }
        $desconto = 0;
        if ($cupom_codigo) {
            $cupom = $this->Cupom_model->get_by_codigo($cupom_codigo);
            if ($cupom && strtotime($cupom->validade) >= strtotime(date('Y-m-d')) && $subtotal >= $cupom->valor_minimo) {
                $desconto = $cupom->desconto;
            }
        }
        $total = $subtotal + $frete - $desconto;
        // Salva pedido
        $pedido_id = $this->Pedido_model->insert([
            'status' => 'novo',
            'total' => $total,
            'cliente' => $cliente,
            'endereco' => $endereco,
            'cep' => $cep,
            'email' => $email
        ]);
        // Salva itens e atualiza estoque
        foreach ($carrinho as $item) {
            $item_data = [
                'pedido_id' => $pedido_id,
                'quantidade' => $item['quantidade'],
                'preco' => $item['preco']
            ];
            
            if (isset($item['variacao_id'])) {
                $item_data['variacao_id'] = $item['variacao_id'];
            } else {
                $item_data['produto_id'] = $item['produto_id'];
            }
            
            $this->Pedido_itens_model->insert($item_data);
            // Atualiza estoque
            if (isset($item['variacao_id'])) {
                $estoque = $this->Estoque_model->get_by_variacao($item['variacao_id']);
                if ($estoque) {
                    $nova_qtd = $estoque->quantidade - $item['quantidade'];
                    $this->Estoque_model->update($estoque->id, ['quantidade' => max(0, $nova_qtd)]);
                }
            } else {
                $estoque = $this->Estoque_model->get_by_produto($item['produto_id']);
                if ($estoque) {
                    $nova_qtd = $estoque->quantidade - $item['quantidade'];
                    $this->Estoque_model->update($estoque->id, ['quantidade' => max(0, $nova_qtd)]);
                }
            }
        }
        // (Opcional) Enviar e-mail de confirmação (implementar depois)
        $this->enviar_email($email, $cliente, $pedido_id);
        // Limpa carrinho
        $this->session->unset_userdata('carrinho');
        $this->session->set_flashdata('sucesso', 'Pedido realizado com sucesso!');
        redirect('produtos');
    }

    public function validar_cupom() {
        $codigo = $this->input->post('cupom');
        $subtotal = $this->input->post('subtotal');
        $cupom = $this->Cupom_model->get_by_codigo($codigo);
        $res = [
            'status' => 'erro',
            'desconto' => 0,
            'mensagem' => 'Cupom inválido ou não encontrado.'
        ];
        if ($cupom) {
            if (strtotime($cupom->validade) < strtotime(date('Y-m-d'))) {
                $res['mensagem'] = 'Cupom expirado.';
            } elseif ($subtotal < $cupom->valor_minimo) {
                $res['mensagem'] = 'Subtotal mínimo para este cupom: R$ ' . number_format($cupom->valor_minimo, 2, ',', '.');
            } else {
                $res['status'] = 'ok';
                $res['desconto'] = $cupom->desconto;
                $res['mensagem'] = 'Cupom aplicado! Desconto de R$ ' . number_format($cupom->desconto, 2, ',', '.');
            }
        }
        echo json_encode($res);
        exit;
    }
} 