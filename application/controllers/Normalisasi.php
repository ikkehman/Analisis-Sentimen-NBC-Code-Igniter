<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Normalisasi extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // Load model events
    $this->load->model('model_normalisasi');
    $this->load->library('datatables');
  }

  public function index()
  {
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Data untuk page index
    $data['pageTitle'] = 'Data Normalisasi';
    $data['pageContent'] = $this->load->view('normalisasi/normalisasiList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {

        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('upnormal', 'Kata Awal', 'required');
      $this->form_validation->set_rules('normal', 'Kata Normalisasi', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'upnormal' => $this->input->post('upnormal'),
          'normal' => $this->input->post('normal'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_normalisasi->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan normalisasi');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan normalisasi');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('normalisasi/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
    $data['pageTitle'] = 'Tambah Data Normalisasi';
    $data['pageContent'] = $this->load->view('normalisasi/normalisasiAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_normal = null)
  {
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('upnormal', 'Kata Awal', 'required');
      $this->form_validation->set_rules('normal', 'Kata Normalisasi', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'upnormal' => $this->input->post('upnormal'),
          'normal' => $this->input->post('normal'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_normalisasi->update($id_normalisasi, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui normalisasi');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui normalisasi');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('normalisasi/edit/'.$id_normalisasi, 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $normalisasi = $this->model_normalisasi->get_where(array('id_normal ' => $id_normal))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$normalisasi) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data Normalisasi';
    $data['normalisasi'] = $normalisasi;
    $data['pageContent'] = $this->load->view('normalisasi/normalisasiEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_normal)
  {
        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Ambil data event dari database
    $normalisasi = $this->model_normalisasi->get_where(array('id_normal ' => $id_normal))->row();

    // Jika data event tidak ada maka show 404
    if (!$normalisasi) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_normalisasi->delete($id_normal);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus normalisasi');
    else $message = array('status' => true, 'message' => 'Gagal menghapus normalisasi');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('normalisasi', 'refresh');

  }
  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_normalisasi->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_normal');
        foreach ($list_id as $id_normal) {
            $this->model_normalisasi->delete_by_id($id_normal);
        }
        echo json_encode(array("status" => TRUE));
    }


}