<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{
  public function __construct()
  {
    parent::__construct();

    // Cek apakah user sudah login
    $this->cekLogin();

    // Load model
    $this->load->model('model_dashboard');
  }

    public function index()
  {
    $data['pageTitle'] = 'Dashboard';
    $data['hitungtot'] = $this->model_dashboard->hitungtot();
    $data['hitungneg'] = $this->model_dashboard->hitungneg();
    $data['hitungpos'] = $this->model_dashboard->hitungpos();
    $data['pageContent'] = $this->load->view('dashboard/admin', $data, TRUE);
    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }
}