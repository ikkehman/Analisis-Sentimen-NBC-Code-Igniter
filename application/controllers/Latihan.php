<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Latihan extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    include APPPATH . 'third_party/stem/function.php';
    //require_once APPPATH.'third_party/stem/ClassNazief.php';
    //require_once('../third_party/stem/ClassNazief.php');
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Load model events
    $this->load->model('model_latihan');
    $this->load->library('datatables'); 
  }

  public function index()
  {
    // Data untuk page index
    $data['pageTitle'] = 'Data latihan';
    $data['pageContent'] = $this->load->view('latihan/latihanList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('komentar', 'Komentar', 'required');
      $this->form_validation->set_rules('sentimen', 'Sentimen', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        $stem = stem($this->input->post('komentar'));
        $stems = implode(", ",$stem);
    
        $data = array(
          'komentar' => $this->input->post('komentar'),
          'sentimen' => $this->input->post('sentimen'),
          'stem' => $stems,
        );

        // Jalankan function insert pada model_events
        $query = $this->model_latihan->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan latihan');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan latihan');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('latihan/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
        $data['latihan'] = $this->db->select('*')
                  ->from('skripsi_komentar')
                  ->get();
    $data['pageTitle'] = 'Tambah Data latihan';
    $data['pageContent'] = $this->load->view('latihan/latihanAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_latihan = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('nama_latihan', 'Nama', 'required');
      $this->form_validation->set_rules('no_urutlatihan', 'latihan', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

      if (!empty($_FILES['lambang']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = $id_latihan.'_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('lambang')) {
            exit($this->upload->display_errors());
        }
$data = array('lambang' => $this->upload->data()['file_name'],);
$query = $this->model_latihan->update($id_latihan, $data);
        //$data['avatar'] = $this->upload->data()['file_name'];
      }

        $data = array(
          'no_urutlatihan' => $this->input->post('no_urutlatihan'),
          'nama_latihan' => $this->input->post('nama_latihan'),
          'akronim' => $this->input->post('akronim'),
          'tahun' => $this->input->post('tahun'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_latihan->update($id_latihan, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui latihan');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui latihan');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
      } 
    }
    
    // Ambil data event dari database
    $latihan = $this->model_latihan->get_where(array('id_latihan' => $id_latihan))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$latihan) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data latihan';
    $data['latihan'] = $latihan;
    $data['pageContent'] = $this->load->view('latihan/latihanEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_latihan)
  {
    // Ambil data event dari database
    $latihan = $this->model_latihan->get_where(array('no' => $id_latihan))->row();

    // Jika data event tidak ada maka show 404
    if (!$latihan) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_latihan->delete($id_latihan);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus latihan');
    else $message = array('status' => true, 'message' => 'Gagal menghapus latihan');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('latihan', 'refresh');
  }

  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_latihan->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('no');
        foreach ($list_id as $id_latihan) {
            $this->model_latihan->delete_by_id($id_latihan);
        }
        echo json_encode(array("status" => TRUE));
    }

}