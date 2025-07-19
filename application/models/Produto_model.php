<?php
class Produto_model extends CI_Model {
    public function get_all() {
        return $this->db->get('produtos')->result();
    }
    public function get($id) {
        return $this->db->get_where('produtos', ['id' => $id])->row();
    }
    public function insert($data) {
        $this->db->insert('produtos', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id)->update('produtos', $data);
    }
    public function delete($id) {
        $this->db->where('id', $id)->delete('produtos');
    }
} 