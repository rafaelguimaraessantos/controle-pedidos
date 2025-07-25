<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layout Helper
 * 
 * Helper para facilitar o uso do layout nas controllers
 */

if (!function_exists('render_page')) {
    /**
     * Renderiza uma página usando o layout principal
     * 
     * @param string $view Nome da view
     * @param array $data Dados para a view
     * @param string $title Título da página
     * @param string $subtitle Subtítulo da página
     * @param array $breadcrumb Breadcrumb da página
     * @return void
     */
    function render_page($view, $data = array(), $title = '', $subtitle = '', $breadcrumb = array()) {
        $CI =& get_instance();
        
        // Carrega a view específica
        $content = $CI->load->view($view, $data, TRUE);
        
        // Prepara os dados do layout
        $layout_data = array(
            'content' => $content,
            'title' => $title,
            'page_title' => $title,
            'page_subtitle' => $subtitle,
            'breadcrumb' => $breadcrumb
        );
        
        // Renderiza o layout
        $CI->load->view('layout/main', $layout_data);
    }
}

if (!function_exists('set_breadcrumb')) {
    /**
     * Define o breadcrumb da página
     * 
     * @param array $items Array com os itens do breadcrumb
     * @return array
     */
    function set_breadcrumb($items) {
        return $items;
    }
}

if (!function_exists('add_breadcrumb_item')) {
    /**
     * Adiciona um item ao breadcrumb
     * 
     * @param string $text Texto do item
     * @param string $url URL do item (opcional)
     * @return array
     */
    function add_breadcrumb_item($text, $url = '') {
        $item = array('text' => $text);
        if (!empty($url)) {
            $item['url'] = $url;
        }
        return $item;
    }
}

if (!function_exists('set_page_title')) {
    /**
     * Define o título da página
     * 
     * @param string $title Título da página
     * @param string $subtitle Subtítulo da página
     * @return array
     */
    function set_page_title($title, $subtitle = '') {
        return array(
            'title' => $title,
            'subtitle' => $subtitle
        );
    }
}

if (!function_exists('get_active_menu')) {
    /**
     * Retorna a classe 'active' para o menu atual
     * 
     * @param string $segment Segmento da URL para verificar
     * @return string
     */
    function get_active_menu($segment) {
        $CI =& get_instance();
        return ($CI->uri->segment(1) == $segment) ? 'active' : '';
    }
} 