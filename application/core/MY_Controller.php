<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
  public function cekLogin()
  {
    // Jika belum ada session username maka 
    // redirect ke halaman auth/login
    if (!$this->session->userdata('username')) {
      redirect('auth/login');
    }
  }
  
  public function getUserData()
  {
    // Ambil semua data session
    $userData = $this->session->userdata();

    // Return userdata
    return $userData;
  }

  public function isKepalaSuku()
  {
    // Mengambil data session
    $userData = $this->getUserData();

    // Jika level user bukan administrator
    // maka redirect ke halaman 404
    if ($userData['level'] !== 'administrator') show_404();
  }

  public function isValidator()
  {
    // Mengambil data session
    $userData = $this->getUserData();

    // Jika level user bukan administrator
    // maka redirect ke halaman 404
    if ($userData['level'] !== 'validator') show_404();
  }

}