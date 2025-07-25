<?php
class Cupons extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Cupom_model');
        $this->load->helper(array('form', 'url'));
    }
    public function index() {
        $data['cupons'] = $this->Cupom_model->get_all();
        
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Cupons')
        );
        
        render_page('cupons_list', $data, 'Cupons', 'Gerencie os cupons de desconto', $breadcrumb);
    }
    public function create() {
        // Breadcrumb
        $breadcrumb = array(
            add_breadcrumb_item('Cupons', base_url('cupons')),
            add_breadcrumb_item('Novo Cupom')
        );
        
        render_page('cupons_form', array(), 'Novo Cupom', 'Crie um novo cupom de desconto', $breadcrumb);
    }
    public function store() {
        $cupom = [
            'codigo' => $this->input->post('codigo'),
            'validade' => $this->input->post('validade'),
            'valor_minimo' => $this->input->post('valor_minimo'),
            'desconto' => $this->input->post('desconto')
        ];
        $this->Cupom_model->insert($cupom);
        redirect('cupons');
    }
    public function edit($id) {
        $data['cupom'] = $this->Cupom_model->get($id);
        $this->load->view('cupons_form', $data);
    }
    public function update($id) {
        $cupom = [
            'codigo' => $this->input->post('codigo'),
            'validade' => $this->input->post('validade'),
            'valor_minimo' => $this->input->post('valor_minimo'),
            'desconto' => $this->input->post('desconto')
        ];
        $this->Cupom_model->update($id, $cupom);
        redirect('cupons');
    }
    public function delete($id) {
        $this->Cupom_model->delete($id);
        redirect('cupons');
    }
} 