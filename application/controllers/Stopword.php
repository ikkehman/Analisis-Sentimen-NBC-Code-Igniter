<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stopword extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // Load model events
    $this->load->model('model_stopword');
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
    $data['pageTitle'] = 'Data stopword';
    $data['pageContent'] = $this->load->view('stopword/stopwordList', $data, TRUE);

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
      $this->form_validation->set_rules('stopword', 'Kata Stopword', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        
        $data = array(
          'stopword' => $this->input->post('stopword'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_stopword->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan stopword');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan stopword');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('stopword/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
    $data['pageTitle'] = 'Tambah Data stopword';
    $data['pageContent'] = $this->load->view('stopword/stopwordAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_stopword = null)
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
      $this->form_validation->set_rules('stopword', 'Kata Stopword', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'stopword' => $this->input->post('stopword'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_stopword->update($id_stopword, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui stopword');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui stopword');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('stopword/edit/'.$id_stopword, 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $stopword = $this->model_stopword->get_where(array('id' => $id_stopword))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$stopword) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data stopword';
    $data['stopword'] = $stopword;
    $data['pageContent'] = $this->load->view('stopword/stopwordEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_stopword)
  {
        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Ambil data event dari database
    $stopword = $this->model_stopword->get_where(array('id ' => $id_stopword))->row();

    // Jika data event tidak ada maka show 404
    if (!$stopword) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_stopword->delete($id_stopword);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus stopword');
    else $message = array('status' => true, 'message' => 'Gagal menghapus stopword');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('stopword', 'refresh');

  }
  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_stopword->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id_stopword) {
            $this->model_stopword->delete_by_id($id_stopword);
        }
        echo json_encode(array("status" => TRUE));
    }


}