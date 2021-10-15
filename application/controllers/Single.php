<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Single extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    include APPPATH . 'third_party/stem/function.php';
    include APPPATH . 'third_party/stem/ClassAnalyze.php';
    //require_once APPPATH.'third_party/stem/ClassNazief.php';
    //require_once('../third_party/stem/ClassNazief.php');
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Load model events
    $this->load->model('model_single');
    $this->load->library('datatables'); 
  }

  public function index()
  {
    // Data untuk page index
    $analyze = new Analyze();
    $data['pageTitle'] = 'Data single';
    $data['pageContent'] = $this->load->view('single/singleList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    // Jika form di submit jalankan blok kode ini
    $analyze = new Analyze();
    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('kalimat', 'Kalimat', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        $sentimen = $analyze->single_process($this->input->post('komentar'));

        // refresh page
        redirect('single/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
        $data['single'] = $this->db->select('*')
                  ->from('skripsi_komentar')
                  ->get();
    $data['pageTitle'] = 'Tambah Data single';
    $data['pageContent'] = $this->load->view('single/singleAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_single->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('no');
        foreach ($list_id as $id_single) {
            $this->model_single->delete_by_id($id_single);
        }
        echo json_encode(array("status" => TRUE));
    }

}