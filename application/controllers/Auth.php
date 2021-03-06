<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function proses_login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $rule = $this->input->post('rule', true);
        $cek_users = $this->login_model->auth_users($username, $password);
        $cek_guru = $this->login_model->auth_guru($username, $password);
        $cek_siswa = $this->login_model->auth_siswa($username, $password);

        if ($rule == 'siswa') {
            if ($cek_siswa->num_rows() > 0) {
                $data = $cek_siswa->row_array();
                $this->session->set_userdata('masuk', TRUE);
                $this->session->set_userdata('akses', 'siswa');
                $this->session->set_userdata('ses_id', $data['id_siswa']);
                $this->session->set_userdata('ses_nis', $data['username']);
                $this->session->set_userdata('ses_nama', $data['nama_siswa']);
                $this->session->set_userdata('ses_photo', $data['photo']);
                redirect('dashboard');
            } else {  // jika username dan password tidak ditemukan atau salah
                $url = base_url('auth');
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                    Username atau Password Salah</div>'
                );
                redirect($url);
            }
        } else if ($rule == 'guru') {
            if ($cek_guru->num_rows() > 0) {
                $data = $cek_guru->row_array();
                $this->session->set_userdata('masuk', TRUE);
                if ($data['level'] == 'guru') {
                    $this->session->set_userdata('akses', 'guru');
                    $this->session->set_userdata('ses_id', $data['id_guru']);
                    $this->session->set_userdata('ses_id_mapel', $data['id_mapel']);
                    $this->session->set_userdata('ses_nama', $data['nama_guru']);
                    $this->session->set_userdata('ses_photo', $data['photo']);
                    redirect('dashboard');
                } else {
                    $this->session->set_userdata('akses', 'wali_kelas');
                    $this->session->set_userdata('ses_id', $data['id_guru']);
                    $this->session->set_userdata('ses_id_kelas', $data['id_kelas']);
                    $this->session->set_userdata('ses_id_mapel', $data['id_mapel']);
                    $this->session->set_userdata('ses_nama', $data['nama_guru']);
                    $this->session->set_userdata('ses_photo', $data['photo']);
                    redirect('dashboard');
                }
            } else {  // jika username dan password tidak ditemukan atau salah
                $url = base_url('auth');
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                    Username atau Password Salah</div>'
                );
                redirect($url);
            }
        } else {
            if ($cek_users->num_rows() > 0) {
                $data = $cek_users->row_array();
                if ($data['blokir'] == 'N') {
                    $this->session->set_userdata('masuk', TRUE);
                    $this->session->set_userdata('akses', 'admin');
                    $this->session->set_userdata('ses_id', $data['id']);
                    $this->session->set_userdata('ses_nama', $data['username']);
                    redirect('dashboard');
                } else {
                    $url = base_url('auth');
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                        Akun anda sudah <strong>diblokir</strong>, silahkan hubungi admin !</div>'
                    );
                    redirect($url);
                }
            } else {  // jika username dan password tidak ditemukan atau salah
                $url = base_url('auth');
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                    Username atau Password Salah</div>'
                );
                redirect($url);
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $url = base_url('auth');
        redirect($url);
    }
}
