<?php
class Pedido_model extends CI_Model {
    public function get_all() {
        return $this->db->get('pedidos')->result();
    }
    public function get($id) {
        return $this->db->get_where('pedidos', ['id' => $id])->row();
    }
    public function insert($data) {
        $this->db->insert('pedidos', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id)->update('pedidos', $data);
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('pedidos');
    }
} 