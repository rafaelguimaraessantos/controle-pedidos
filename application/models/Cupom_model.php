<?php
class Cupom_model extends CI_Model {
    public function get_all() {
        return $this->db->get('cupons')->result();
    }
    public function get($id) {
        return $this->db->get_where('cupons', ['id' => $id])->row();
    }
    public function insert($data) {
        $this->db->insert('cupons', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id)->update('cupons', $data);
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('cupons');
    }
    public function get_by_codigo($codigo) {
        return $this->db->get_where('cupons', ['codigo' => $codigo])->row();
    }
} 