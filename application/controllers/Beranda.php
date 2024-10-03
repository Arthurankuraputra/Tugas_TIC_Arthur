<?php

/**
 *  summary
 */
class Beranda extends CI_Controller
{
    public function  index()
    {
        $data['judul'] = 'Halaman Beranda';
        $this->load->view('Templates/header', $data);
        $this->load->view('beranda/index', $data);
        $this->load->view('Templates/footer');
    }
}
