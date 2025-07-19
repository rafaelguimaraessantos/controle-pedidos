<?php
class Pedidos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pedido_model');
        $this->load->model('Pedido_itens_model');
        $this->load->model('Produto_model');
        $this->load->model('Variacao_model');
        $this->load->helper('url');
    }
    public function index() {
        $data['pedidos'] = $this->Pedido_model->get_all();
        $this->load->view('pedidos_list', $data);
    }
    public function show($id) {
        $data['pedido'] = $this->Pedido_model->get($id);
        $data['itens'] = $this->Pedido_itens_model->get_by_pedido($id);
        $this->load->view('pedido_detalhe', $data);
    }
    public function webhook() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if (!$id || !$status) {
            show_error('ID e status obrigatórios', 400);
        }
        if ($status === 'cancelado') {
            $this->Pedido_model->delete($id);
        } else {
            $this->Pedido_model->update($id, ['status' => $status]);
        }
        echo 'OK';
    }
    public function enviar_email($pedido_id) {
        // Estrutura para envio de e-mail ao finalizar pedido
        // Implementar integração com biblioteca de e-mail conforme necessário
    }
} 