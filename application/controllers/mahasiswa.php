<?php

class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['judul'] = 'Halaman Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->getAllMahasiswa();
        if ($this->input->post('keyword')) {
            $data['mahasiswa'] = $this->Mahasiswa_model->cariDataMahasiswa();
        }
        $data['jurusan'] = $this->Mahasiswa_model->getAllJurusan();

        // Validasi form untuk tambah data
        $this->form_validation->set_rules('kode', 'Kode', 'required|is_unique[mahasiswa.kode]');
        $this->form_validation->set_rules('matakuliah', 'Matakuliah', 'required|is_unique[mahasiswa.matakuliah]');
        $this->form_validation->set_rules('sks', 'SKS', 'required|numeric');
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('mahasiswa/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi berhasil
            $data = [
                'kode' => $this->input->post('kode'),
                'matakuliah' => $this->input->post('matakuliah'),
                'sks' => $this->input->post('sks'),
                'semester' => $this->input->post('semester'),
                'jurusan' => $this->input->post('jurusan'),
            ];
            $this->db->insert('mahasiswa', $data);
            $this->session->set_flashdata('flash', 'ditambahkan');
            redirect('mahasiswa');
        }
    }

    public function Ubah()
    {
        $this->Mahasiswa_model->ubahDataMahasiswa($id);
        $this->session->set_flashdata('flash', 'diubah');
        redirect('mahasiswa');
    }

    public function hapus($id)
    {
        $this->Mahasiswa_model->hapusDataMahasiswa($id);
        $this->session->set_flashdata('flash', 'dihapus');
        redirect('mahasiswa');
    }
}
