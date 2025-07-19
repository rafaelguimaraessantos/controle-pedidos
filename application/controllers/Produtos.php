<?php
class Produtos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Variacao_model');
        $this->load->model('Estoque_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session'); // Garante acesso à sessão
    }
    public function index() {
        $data['produtos'] = $this->Produto_model->get_all();
        foreach ($data['produtos'] as &$produto) {
            // Estoque de produto simples
            $estoque_simples = $this->Estoque_model->get_by_produto($produto->id);
            $produto->estoque = $estoque_simples ? $estoque_simples->quantidade : 0;
            // Soma estoques das variações
            $variacoes = $this->Variacao_model->get_by_produto($produto->id);
            foreach ($variacoes as $v) {
                $estoque_var = $this->Estoque_model->get_by_variacao($v->id);
                $produto->estoque += $estoque_var ? $estoque_var->quantidade : 0;
            }
        }
        
        // Conta itens no carrinho
        $carrinho = $this->session->userdata('carrinho') ?: [];
        $total_itens_carrinho = 0;
        foreach ($carrinho as $item) {
            $total_itens_carrinho += $item['quantidade'];
        }
        $data['total_itens_carrinho'] = $total_itens_carrinho;
        
        $this->load->view('produtos_list', $data);
    }
    public function create() {
        // Conta itens no carrinho
        $carrinho = $this->session->userdata('carrinho') ?: [];
        $total_itens_carrinho = 0;
        foreach ($carrinho as $item) {
            $total_itens_carrinho += $item['quantidade'];
        }
        $data['total_itens_carrinho'] = $total_itens_carrinho;
        
        $this->load->view('produtos_form', $data);
    }
    public function store() {
        $produto = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao')
        ];
        $produto_id = $this->Produto_model->insert($produto);
        $variacoes = $this->input->post('variacoes');
        if ($variacoes) {
            foreach ($variacoes as $v) {
                $v_data = [
                    'produto_id' => $produto_id,
                    'nome' => $v['nome'],
                    'preco' => $v['preco']
                ];
                $v_id = $this->Variacao_model->insert($v_data);
                $this->Estoque_model->insert([
                    'variacao_id' => $v_id,
                    'quantidade' => $v['estoque']
                ]);
            }
        } else {
            // Produto simples: estoque direto
            $estoque = $this->input->post('estoque');
            if ($estoque !== null && $estoque !== '') {
                $this->Estoque_model->insert([
                    'produto_id' => $produto_id,
                    'quantidade' => $estoque
                ]);
            }
        }
        redirect('produtos');
    }
    public function edit($id) {
        $data['produto'] = $this->Produto_model->get($id);
        $data['variacoes'] = $this->Variacao_model->get_by_produto($id);
        foreach ($data['variacoes'] as &$v) {
            $estoque = $this->Estoque_model->get_by_variacao($v->id);
            $v->estoque = $estoque ? $estoque->quantidade : 0;
        }
        $estoque_simples = $this->Estoque_model->get_by_produto($id);
        $data['estoque'] = $estoque_simples ? $estoque_simples->quantidade : '';
        
        // Conta itens no carrinho
        $carrinho = $this->session->userdata('carrinho') ?: [];
        $total_itens_carrinho = 0;
        foreach ($carrinho as $item) {
            $total_itens_carrinho += $item['quantidade'];
        }
        $data['total_itens_carrinho'] = $total_itens_carrinho;
        
        $this->load->view('produtos_form', $data);
    }
    public function update($id) {
        $produto = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao')
        ];
        $this->Produto_model->update($id, $produto);
        // Remove variações e estoques antigos
        $variacoes_antigas = $this->Variacao_model->get_by_produto($id);
        foreach ($variacoes_antigas as $v) {
            $this->Estoque_model->delete($this->Estoque_model->get_by_variacao($v->id)->id);
            $this->Variacao_model->delete($v->id);
        }
        $estoque_simples = $this->Estoque_model->get_by_produto($id);
        if ($estoque_simples) {
            $this->Estoque_model->delete($estoque_simples->id);
        }
        // Adiciona novas variações/estoques
        $variacoes = $this->input->post('variacoes');
        if ($variacoes) {
            foreach ($variacoes as $v) {
                $v_data = [
                    'produto_id' => $id,
                    'nome' => $v['nome'],
                    'preco' => $v['preco']
                ];
                $v_id = $this->Variacao_model->insert($v_data);
                $this->Estoque_model->insert([
                    'variacao_id' => $v_id,
                    'quantidade' => $v['estoque']
                ]);
            }
        } else {
            $estoque = $this->input->post('estoque');
            if ($estoque !== null && $estoque !== '') {
                $this->Estoque_model->insert([
                    'produto_id' => $id,
                    'quantidade' => $estoque
                ]);
            }
        }
        redirect('produtos');
    }
    public function delete($id) {
        // Exclui produto, variações e estoques relacionados
        $variacoes = $this->Variacao_model->get_by_produto($id);
        foreach ($variacoes as $v) {
            $estoque = $this->Estoque_model->get_by_variacao($v->id);
            if ($estoque) $this->Estoque_model->delete($estoque->id);
            $this->Variacao_model->delete($v->id);
        }
        $estoque_simples = $this->Estoque_model->get_by_produto($id);
        if ($estoque_simples) $this->Estoque_model->delete($estoque_simples->id);
        $this->Produto_model->delete($id);
        redirect('produtos');
    }
} 