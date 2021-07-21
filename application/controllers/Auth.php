<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
  public function cekAkun()
  {
    // Memanggil model users
    $this->load->model('model_users');

    // Mengambil data dari form login dengan method POST
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    // Jalankan function cekAkun pada model_users
            $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);
    $query = $this->model_users->cekAkun($username, $password);

    // Jika query gagal maka return false
    if (!$query) {
      
      // Mengatur pesan error validasi data
      $this->form_validation->set_message('cekAkun', 'Username atau password yang Anda masukkan salah!');
      return false;
    
    // Jika berhasil maka set user session dan return true
    } elseif (!isset($response['success']) || $response['success'] <> true) 
    {
      $this->form_validation->set_message('cekAkun', 'Captcha wajib isi SETAN!!!');
      return false;
    } 
    else {

      // data user dalam bentuk array
      $userData = array(
        'username' => $query->username,
        'level' => $query->level,
        'nama' => $query->nama,
        'telp' => $query->telp,
        'jk' => $query->jk,
        'avatar' => $query->avatar,
        'logged_in' => true
      );
			
      // set session untuk user
			$this->session->set_userdata($userData);

      return TRUE;
    }
  }

  public function login()
  {
    // Jika user telah login, redirect ke base_url
    if ($this->session->userdata('logged_in')) redirect(base_url());

        $data = array(
            'captcha' => $this->recaptcha->getWidget(), // menampilkan recaptcha
            'script_captcha' => $this->recaptcha->getScriptTag(), // javascript recaptcha ditaruh di head
        );
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {
      
      // Mengatur validasi data username,
      // required = tidak boleh kosong
      $this->form_validation->set_rules('username', 'Username', 'required');

      // Mengatur validasi data password,
      // required = tidak boleh kosong
      // callback_cekAkun = menjalankan function cekAkun()
			$this->form_validation->set_rules('password', 'Password', 'required|callback_cekAkun');
			
      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
      // Jalankan validasi jika semuanya benar maka redirect ke controller dashboard
			if ($this->form_validation->run() === TRUE) {
        redirect('dashboard');
			} 
    }
    
    // Jalankan view auth/login.php
    $this->load->view('auth/login', $data);
  }

  public function logout()
  {
    // Hapus semua data pada session
    $this->session->sess_destroy();

    // redirect ke halaman login	
    redirect('auth/login');
  }
}