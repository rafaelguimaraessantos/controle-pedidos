<?php
class Cupons extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Cupom_model');
        $this->load->helper(array('form', 'url'));
    }
    public function index() {
        $data['cupons'] = $this->Cupom_model->get_all();
        $this->load->view('cupons_list', $data);
    }
    public function create() {
        $this->load->view('cupons_form');
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