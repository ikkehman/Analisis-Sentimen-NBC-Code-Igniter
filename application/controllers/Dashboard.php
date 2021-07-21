<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{
  public function __construct()
  {
    parent::__construct();

    // Cek apakah user sudah login
    $this->cekLogin();

    // Load model
    //$this->load->model('model_dashboard');
  }

    public function index()
  {
    $data['pageTitle'] = 'Profile';
    $data['pageContent'] = $this->load->view('dashboard/admin', $data, TRUE);
    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }
}