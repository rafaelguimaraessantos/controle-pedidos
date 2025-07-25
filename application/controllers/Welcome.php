<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test_db()
	{
		// Teste de conexão com o banco de dados
		if ($this->db->conn_id) {
			echo "Conexão com o banco de dados estabelecida com sucesso!<br>";
			
			// Testar uma query simples
			$query = $this->db->query("SELECT COUNT(*) as total FROM produtos");
			if ($query) {
				$result = $query->row();
				echo "Total de produtos: " . $result->total . "<br>";
			} else {
				echo "Erro ao executar query: " . $this->db->error()['message'] . "<br>";
			}
		} else {
			echo "Erro: Não foi possível conectar ao banco de dados.<br>";
			echo "Erro: " . $this->db->error()['message'] . "<br>";
		}
	}
}
