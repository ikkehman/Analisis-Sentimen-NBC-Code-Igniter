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

  public function edit($id_single = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('nama_single', 'Nama', 'required');
      $this->form_validation->set_rules('no_urutsingle', 'single', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

      if (!empty($_FILES['lambang']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = $id_single.'_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('lambang')) {
            exit($this->upload->display_errors());
        }
$data = array('lambang' => $this->upload->data()['file_name'],);
$query = $this->model_single->update($id_single, $data);
        //$data['avatar'] = $this->upload->data()['file_name'];
      }

        $data = array(
          'no_urutsingle' => $this->input->post('no_urutsingle'),
          'nama_single' => $this->input->post('nama_single'),
          'akronim' => $this->input->post('akronim'),
          'tahun' => $this->input->post('tahun'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_single->update($id_single, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui single');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui single');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
      } 
    }
    
    // Ambil data event dari database
    $single = $this->model_single->get_where(array('id_single' => $id_single))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$single) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data single';
    $data['single'] = $single;
    $data['pageContent'] = $this->load->view('single/singleEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_single)
  {
    // Ambil data event dari database
    $single = $this->model_single->get_where(array('no' => $id_single))->row();

    // Jika data event tidak ada maka show 404
    if (!$single) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_single->delete($id_single);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus single');
    else $message = array('status' => true, 'message' => 'Gagal menghapus single');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('single', 'refresh');
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