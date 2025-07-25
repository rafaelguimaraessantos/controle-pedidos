<?php
class Variacao_model extends CI_Model {
    public function get_all() {
        return $this->db->get('variacoes')->result();
    }
    public function get_by_produto($produto_id) {
        return $this->db->get_where('variacoes', ['produto_id' => $produto_id])->result();
    }
    public function get($id) {
        return $this->db->get_where('variacoes', ['id' => $id])->row();
    }
    public function insert($data) {
        $this->db->insert('variacoes', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id)->update('variacoes', $data);
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('variacoes');
    }
} 