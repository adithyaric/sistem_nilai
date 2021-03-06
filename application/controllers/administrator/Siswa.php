<?php

class Siswa extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('siswa_model');
    //validasi jika user belum login
    if ($this->session->userdata('masuk') != TRUE) {
      echo '<script>alert("Anda harus login terlebih dahulu");</script>';
      echo '<script>window.location.href = "' . base_url('auth') . '";</script>';
    } else if ($this->session->userdata('akses') != 'admin') {
      echo '<script>alert("Anda tidak diizinkan mengakses halaman ini");</script>';
      echo '<script>window.location.href = "' . base_url('dashboard') . '";</script>';
    }
  }

  public function index()
  {
    $data['siswa'] = $this->siswa_model->tampil_data_siswa()->result();
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('siswa/siswa', $data);
    $this->load->view('templates/footer');
  }
  public function detail($id)
  {
    $data['detail'] = $this->siswa_model->ambil_id_siswa($id);
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('siswa/siswa_detail', $data);
    $this->load->view('templates/footer');
  }

  public function tambah_siswa()
  {
    $data['kelas'] = $this->siswa_model->tampil_data('kelas')->result();
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('siswa/siswa_form', $data);
    $this->load->view('templates/footer');
  }

  public function tambah_siswa_aksi()
  {
    $username      = $this->input->post('username', true);
    $password      = $this->input->post('password');
    $nama_siswa    = $this->input->post('nama_siswa');
    $tanggal_lahir = $this->input->post('tanggal_lahir');
    $tempat_lahir  = $this->input->post('tempat_lahir');
    $agama         = $this->input->post('agama');
    $ortu          = $this->input->post('ortu');
    $alamat        = $this->input->post('alamat');
    $jenis_kelamin = $this->input->post('jenis_kelamin');
    $id_kelas    = $this->input->post('id_kelas');
    $photo         = $_FILES['photo']['name'];
    $cek = $this->db->get_where('siswa', array('username' => $username));
    if ($cek->num_rows() != 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
        <strong>Maaf!</strong> NIS Siswa Sudah Ada !</div>'
      );
      redirect(base_url() . 'administrator/siswa/tambah_siswa');
      exit();
    }

    $this->_rules();
    if (empty($photo)) {
      $this->form_validation->set_rules('photo', 'photo', 'required', [
        'required' => 'Foto wajib diisi!'
      ]);
    }
    if ($this->form_validation->run() == FALSE) {
      $this->tambah_siswa();
    } else {
      $config['upload_path']   = './assets/uploads';
      $config['allowed_types'] = 'jpg|jpeg|png|gif|tiff';

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('photo')) {
        echo "Gagal Upload!";
        die();
      } else {
        $photo = $this->upload->data('file_name');
      }

      $data = array(
        'username'      => $username,
        'nama_siswa'    => $nama_siswa,
        'tempat_lahir'  => $tempat_lahir,
        'tanggal_lahir' => $tanggal_lahir,
        'agama'         => $agama,
        'ortu'          => $ortu,
        'alamat'        => $alamat,
        'jenis_kelamin' => $jenis_kelamin,
        'id_kelas'      => $id_kelas,
        'photo'         => $photo,
        'password' => $password
      );

      $this->siswa_model->insert_data($data, 'siswa');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data siswa berhasil ditambahkan
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
      );
      redirect('administrator/siswa');
    }
  }

  public function update($id)
  {
    $where = array('username' => $id);
    $data['siswa']     = $this->siswa_model->edit_data($where, 'siswa')->result();
    $data['kelas']     = $this->siswa_model->tampil_data('kelas')->result();
    $data['detail']    = $this->siswa_model->ambil_id_siswa($id);
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('siswa/siswa_update', $data);
    $this->load->view('templates/footer');
  }

  public function update_siswa_aksi()
  {
    $this->_rules();

    $id            = $this->input->post('id_siswa');
    $username      = $this->input->post('username');
    $password      = $this->input->post('password');
    $nama_siswa    = $this->input->post('nama_siswa');
    $tanggal_lahir = $this->input->post('tanggal_lahir');
    $tempat_lahir  = $this->input->post('tempat_lahir');
    $agama         = $this->input->post('agama');
    $ortu          = $this->input->post('ortu');
    $alamat        = $this->input->post('alamat');
    $jenis_kelamin = $this->input->post('jenis_kelamin');
    $id_kelas      = $this->input->post('id_kelas');
    $photo         = $_FILES['userfile']['name'];

    if ($photo) {
      $config['upload_path']   = './assets/uploads';
      $config['allowed_types'] = 'jpg|jpeg|png|gif|tiff';

      $this->load->library('upload', $config);
      if ($this->upload->do_upload('userfile')) {
        $userfile = $this->upload->data('file_name');
        $this->db->set('photo', $userfile);
      } else {
        echo "Photo Gagal di-Upload!";
      }
    }

    $data = array(
      'username'       => $username,
      'password'      => $password,
      'nama_siswa'    => $nama_siswa,
      'tempat_lahir'  => $tempat_lahir,
      'tanggal_lahir' => $tanggal_lahir,
      'agama'         => $agama,
      'ortu'          => $ortu,
      'alamat'        => $alamat,
      'jenis_kelamin' => $jenis_kelamin,
      'id_kelas'    => $id_kelas
    );

    $where = array(
      'id_siswa' => $id,
    );

    $this->siswa_model->update_data($where, $data, 'siswa');
    $this->session->set_flashdata(
      'pesan',
      '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data siswa berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
    );
    redirect('administrator/siswa');
  }

  public function delete($id)
  {
    $where = array('username' => $id);
    $this->siswa_model->hapus_data($where, 'siswa');
    $this->session->set_flashdata(
      'pesan',
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Data siswa berhasil dihapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>'
    );
    redirect('administrator/siswa');
  }

  public function _rules()
  {
    $this->form_validation->set_rules('username', 'username', 'required', [
      'required' => 'nis wajib diisi!'
    ]);
    $this->form_validation->set_rules('password', 'password', 'required', [
      'required' => 'Password wajib diisi!'
    ]);
    $this->form_validation->set_rules('nama_siswa', 'nama_siswa', 'required', [
      'required' => 'Nama siswa wajib diisi!'
    ]);
    $this->form_validation->set_rules('alamat', 'alamat', 'required', [
      'required' => 'Alamat wajib diisi!'
    ]);
    $this->form_validation->set_rules('ortu', 'ortu', 'required', [
      'required' => 'Orang tua/Wali wajib diisi!'
    ]);
    $this->form_validation->set_rules('agama', 'agama', 'required', [
      'required' => 'Agama wajib diisi!'
    ]);
    $this->form_validation->set_rules('tempat_lahir', 'tempat_lahir', 'required', [
      'required' => 'Tempat lahir wajib diisi!'
    ]);
    $this->form_validation->set_rules('tanggal_lahir', 'tanggal_lahir', 'required', [
      'required' => 'Tanggal lahir wajib diisi!'
    ]);
    $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required', [
      'required' => 'Jenis kelamin wajib diisi!'
    ]);
    $this->form_validation->set_rules('id_kelas', 'id_kelas', 'required', [
      'required' => 'Nama Kelas wajib diisi!'
    ]);
  }
}
