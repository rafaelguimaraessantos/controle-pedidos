<?php
class Estoque_model extends CI_Model {
    public function get_by_produto($produto_id) {
        return $this->db->get_where('estoque', ['produto_id' => $produto_id])->row();
    }
    public function get_by_variacao($variacao_id) {
        return $this->db->get_where('estoque', ['variacao_id' => $variacao_id])->row();
    }
    public function insert($data) {
        $this->db->insert('estoque', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id)->update('estoque', $data);
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('estoque');
    }
} 