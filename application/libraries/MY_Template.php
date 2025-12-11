<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Kelas MY_Template
 * 
 * Kelas ini digunakan untuk mengelola template pada CodeIgniter.
 */
class MY_Template
{
    /**
     * @var array $template_data Data template yang akan digunakan.
     */
    protected $template_data = array();

    /**
     * Mengatur data untuk template.
     * 
     * @param string $name Nama variabel template.
     * @param mixed $value Nilai variabel template.
     * 
     * @example 
     * $template->set('judul', 'Selamat Datang');
     */
    public function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    /**
     * Memuat view ke dalam template.
     * 
     * @param string $template Nama file template.
     * @param string $view Nama file view yang akan dimuat.
     * @param array $view_data Data yang akan dikirim ke view.
     * @param bool $return Jika TRUE, view akan dikembalikan sebagai string, jika FALSE, view akan langsung ditampilkan.
     * @return mixed Mengembalikan hasil render view jika $return = TRUE, jika tidak, akan langsung menampilkan view.
     * 
     * @example 
     * $template->load('main_template', 'welcome_message', array('title' => 'Selamat Datang'), TRUE);
     * 
     * @link https://www.matadata.id/codeigniter-tutorial-membuat-template-di-codeigniter/
     */
    public function load($template = '', $view = '', $view_data = array(), $return = FALSE)
    {
        $CI = &get_instance();
        $this->set('_contents', $CI->load->view($view, $view_data, TRUE));
        return $CI->load->view($template, $this->template_data, $return);
    }
}
