<?php
class Pedido_itens_model extends CI_Model {
    public function get_by_pedido($pedido_id) {
        return $this->db->get_where('pedido_itens', ['pedido_id' => $pedido_id])->result();
    }
    public function insert($data) {
        $this->db->insert('pedido_itens', $data);
        return $this->db->insert_id();
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('pedido_itens');
    }
} 