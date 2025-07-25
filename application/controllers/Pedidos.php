<?php
class Pedidos extends MY_Controller {
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
        
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Pedidos')
        );
        
        render_page('pedidos_list', $data, 'Pedidos', 'Gerencie todos os pedidos do sistema', $breadcrumb);
    }
    public function show($id) {
        $data['pedido'] = $this->Pedido_model->get($id);
        $data['itens'] = $this->Pedido_itens_model->get_by_pedido($id);
        
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Pedidos', base_url('pedidos')),
            add_breadcrumb_item('Pedido #' . $id)
        );
        
        render_page('pedido_detalhe', $data, 'Pedido #' . $id, 'Detalhes do pedido', $breadcrumb);
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
    public function enviar_email_pedido($pedido_id) {
        // Estrutura para envio de e-mail ao finalizar pedido
        // Implementar integração com biblioteca de e-mail conforme necessário
    }
} 