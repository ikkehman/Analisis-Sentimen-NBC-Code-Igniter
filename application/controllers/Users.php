<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    
    // Cek apakah user sudah login
    $this->cekLogin();

    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();
    // Load model users
    $this->load->library('datatables');
    $this->load->model('model_users');
  }

  public function index()
  {

    // Data untuk page index
    $data['pageTitle'] = 'Users';

    //$data['wilayah1'] = $this->model_users->get_wilayah1()->result();
    $data['pageContent'] = $this->load->view('users/userList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {
      
      // Mengatur validasi data username,
      // # required = tidak boleh kosong
      // # min_length[5] = username harus terdiri dari minimal 5 karakter
      // # is_unique[users.username] = username harus bernilai unique, 
      //   tidak boleh sama dengan record yg sudah ada pada tabel users
      $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.username]|alpha_numeric');

      // Mengatur validasi data password,
      // # required = tidak boleh kosong
      // # min_length[5] = password harus terdiri dari minimal 5 karakter
      $this->form_validation->set_rules('konfirmasi_password', 'Password', 'required|min_length[5]');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
      $this->form_validation->set_message('min_length', '%s minimal %d karakter!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $username = $this->input->post('username');

        $data = array(
          'username' => $username,
          'password' => password_hash($this->input->post('konfirmasi_password'), PASSWORD_DEFAULT),
          'nama' => $this->input->post('nama'),
    'level' => $this->input->post('level'),
        );

        // Jalankan function insert pada model_users
        $query = $this->model_users->insert($data);

      if (!empty($_FILES['avatar']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = $username.'_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('avatar')) {
            exit($this->upload->display_errors());
        }
$data = array('avatar' => $this->upload->data()['file_name'],);
$query = $this->model_users->update($username, $data);
        //$data['avatar'] = $this->upload->data()['file_name'];
      }


        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => '<div class="alert alert-success" role="alert">Berhasil menambahkan user</div>');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan user');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('users/add', 'refresh');
      } 
    }
    
    // Data untuk page users/add
    $data['pageTitle'] = 'Tambah Data User';
    $data['pageContent'] = $this->load->view('users/userAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($username = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      if (!empty($_FILES['avatar']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = $username.'_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('avatar')) {
            exit($this->upload->display_errors());
        }
$data = array('avatar' => $this->upload->data()['file_name'],);
$query = $this->model_users->update($username, $data);
        //$data['avatar'] = $this->upload->data()['file_name'];
      }

      // Mengatur validasi data level,
      // # required = tidak boleh kosong
      // # in_list[administrator, pendaftar] = hanya boleh bernilai 
      //   salah satu di antara administrator atau pendaftar
      $this->form_validation->set_rules('level', 'Level', 'required|in_list[administrator,kawil,pengawas]');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        //reg
    $nama = $this->input->post('nama');
    $level = $this->input->post('level');


        $data = array(
     'level' => $this->input->post('level'),
     'nama' => $nama,
     //'avatar' => $this->upload->data()['file_name'],
        );

        // Jalankan function insert pada model_users
        $query = $this->model_users->update($username, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => '<div class="alert alert-success" role="alert">Berhasil memperbarui user</div>');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui user');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('users/edit/'.$username, 'refresh');
      } 
    }
    
    // Ambil data user dari database
    $user = $this->model_users->get_where(array('username' => $username))->row();

    // Jika data user tidak ada maka show 404
    if (!$user) show_404();

    // Jika form password di submit jalankan blok kode ini
    if ($this->input->post('submit-password')) {

      // Mengatur validasi data password_baru,
      // # required = tidak boleh kosong
      // # min_length[5] = password_baru harus terdiri dari minimal 5 karakter
      $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[5]');

      // Mengatur validasi data konfirmasi_password,
      // # required = tidak boleh kosong
      // # matches = nilai konfirmasi_password harus sama dengan password_baru
      $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
      $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
      $this->form_validation->set_message('matches', '{field} tidak sama dengan {param}.');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'password' => password_hash($this->input->post('konfirmasi_password'), PASSWORD_DEFAULT)
        );


        // Jalankan function update pada model_users
        $query = $this->model_users->update($username, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => '<div class="alert alert-success" role="alert">Berhasil mengganti password</div>');
        else $message = array('status' => true, 'message' => 'Gagal mengganti password');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);
      }

    }

    $data['pageTitle'] = 'Edit Data User';
    $data['user'] = $user;
    $data['pageContent'] = $this->load->view('users/userEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($username)
  {
    // Ambil data user dari database
    $user = $this->model_users->get_where(array('username' => $username ))->row();

    // Jika data user tidak ada maka show 404
    if (!$user) show_404();

    // Jalankan function delete pada model_users
    $query = $this->model_users->delete($username);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus user');
    else $message = array('status' => true, 'message' => 'Gagal menghapus user');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('users', 'refresh');
  }

public function bulk_delete()
    {
        $list_id = $this->input->post('username');
        foreach ($list_id as $username) {
            $this->model_users->delete_by_id($username);
        }
        echo json_encode(array("status" => TRUE));
    }


  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_users->get_all();
}



}