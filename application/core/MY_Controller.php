<?php

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function enviar_email($email, $cliente, $pedido_id)
    {
        $this->load->library('email');
        $this->email->from('rafaelguimaraessantos3@gmail.com', 'Loja Exemplo');
        $this->email->to($email);
        $this->email->subject('Confirmação do Pedido #' . $pedido_id);
        $mensagem = "<h2>Olá, $cliente!</h2>";
        $mensagem .= "<p>Seu pedido #$pedido_id foi recebido com sucesso.</p>";
        $mensagem .= "<p>Obrigado por comprar conosco!</p>";
        $this->email->message($mensagem);
        $this->email->send(); // Envio silencioso
    }
}