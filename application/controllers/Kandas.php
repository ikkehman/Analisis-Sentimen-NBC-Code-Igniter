<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kandas extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // Load model events
    $this->load->model('model_kandas');
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
    $data['pageTitle'] = 'Data kandas';
    $data['pageContent'] = $this->load->view('kandas/kandasList', $data, TRUE);

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
      $this->form_validation->set_rules('katadasar', 'Kata Dasar', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'katadasar' => $this->input->post('katadasar'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_kandas->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan kandas');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan kandas');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('kandas/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
    $data['pageTitle'] = 'Tambah Data kandas';
    $data['pageContent'] = $this->load->view('kandas/kandasAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_kandas = null)
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
      $this->form_validation->set_rules('katadasar', 'Kata Dasar', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'katadasar' => $this->input->post('katadasar'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_kandas->update($id_kandas, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui kandas');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui kandas');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('kandas/edit/'.$id_kandas, 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $kandas = $this->model_kandas->get_where(array('id_ktdasar ' => $id_kandas))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$kandas) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data kandas';
    $data['kandas'] = $kandas;
    $data['pageContent'] = $this->load->view('kandas/kandasEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_kandas)
  {
        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Ambil data event dari database
    $kandas = $this->model_kandas->get_where(array('id_ktdasar ' => $id_kandas))->row();

    // Jika data event tidak ada maka show 404
    if (!$kandas) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_kandas->delete($id_kandas);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus kandas');
    else $message = array('status' => true, 'message' => 'Gagal menghapus kandas');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('kandas', 'refresh');

  }
  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_kandas->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_ktdasar');
        foreach ($list_id as $id_ktdasar) {
            $this->model_kandas->delete_by_id($id_ktdasar);
        }
        echo json_encode(array("status" => TRUE));
    }


}