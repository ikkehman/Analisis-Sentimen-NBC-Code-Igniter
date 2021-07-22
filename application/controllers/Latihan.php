<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Latihan extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    include APPPATH . 'third_party/stem/function.php';
    include APPPATH . 'third_party/stem/ClassAnalyze.php';
    include APPPATH . 'third_party/spreadsheet-reader/php-excel-reader/excel_reader2.php';
    include APPPATH . 'third_party/spreadsheet-reader/SpreadsheetReader.php';
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
        $query = $this->model_latihan->update($id_latihan, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil mengedit latihan');
        else $message = array('status' => true, 'message' => 'Gagal mengedit latihan');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('latihan', 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $latihan = $this->model_latihan->get_where(array('no' => $id_latihan))->row();

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

    public function multi()
    {
      error_reporting (E_ALL ^ E_NOTICE);
      $this->form_validation->set_rules('file_batch', 'File', 'required');

      $start = microtime(true);

      $file = $this->input->post('file_batch');
      $filename = $file['name'];
      $ext = get_extension($filename);
        
      if (!empty($_FILES['file_batch']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './temp';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['file_name'] = date("YmdHis");
        // Load library upload
        $this->load->library('upload', $config); 
        $nama = $this->upload->data()['file_name'];

        //$nama = $this->upload->data('file_name'); 
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('file_batch')) {
            exit($this->upload->display_errors());
        }
        $loc = "temp/".$nama.".xlsx";
        $sp = new SpreadsheetReader($loc);
        $sheet = $sp->Sheets();
  
        $text = array();
        foreach($sheet as $index=>$name){
  
          $sp->ChangeSheet($index);
          foreach($sp as $key=>$row){
            if(!isset($row[0])){
              break;
            }
            if(strlen($row[0]) > 0){
              $text[] = $row[0]; //simpan ke array
            }
          }
        }

        $r=0;
        foreach($text as $key=>$value){
          $out_text[$r] = $value;
          $stem[$r] = stem($value);
  
          $imploded = implode(", ",$stem[$r]);
          $data = array(
            'komentar' => $out_text[$r],
            'stem' => $imploded,
            'sentimen' => '3',
          );
          $query = $this->model_latihan->insert($data);
  
          $r++;
        }
        //endgame
      }
        $data['latihan'] = $this->db->select('*')
                  ->from('skripsi_komentar')
                  ->where(array('sentimen' => 3))
                  ->get();
        $data['r'] = $r;
        $data['stem'] = $stem;
        $data['out_text'] = $out_text;
        $data['test'] = $imploded;
        $data['pageTitle'] = 'Tambah Data multi';
        $data['pageContent'] = $this->load->view('latihan/latihanMulti', $data, TRUE);
    
        // Jalankan view template/layout
        $this->load->view('template/layout', $data);
    }

    public function salah ()
    {
      if(isset($_GET['id']) and isset($_GET['revise'])){
        $id = intval($_GET['id']);
        $revise = intval($_GET['revise']);
      }
      // Ambil data event dari database
      $multi = $this->model_latihan->get_where(array('no' => $id))->row();
  
      // Jika data event tidak ada maka show 404
      if (!$multi) show_404();
  
      // Jalankan function delete pada model_events
      $data = array(
        'sentimen' => $revise,
      );
      $query = $this->model_latihan->update($id, $data);
  
      if($_GET['revise'] == 0){
        $chg = 1;
      }
      else{
        $chg = 0;
      }
      $url = "latihan/salah?id=".intval($_GET['id'])."&revise=3";
      $url1 = "latihan/salah?id=".intval($_GET['id'])."&revise=1";
      $url0 = "latihan/salah?id=".intval($_GET['id'])."&revise=0";
      $data['url'] = $url;
  
      if($multi->sentimen == 1){
        $data['cls'] = "";
        $data['btn'] = "<a href='../$url1' class='revise-btn btn btn-success btn-sm pmd-ripple-effect'>Positif</a>";
    //		create_alert("Success","Berhasil menghapus tanda kesalahan analisis","../validasi.php?set=$row[sets]");
      } else if($multi->sentimen == 0){
        $data['cls'] = "";
        $data['btn'] = "<a href='../$url0' class='revise-btn btn btn-danger btn-sm pmd-ripple-effect'>Negatif</a>";
    //		create_alert("Success","Berhasil menghapus tanda kesalahan analisis","../validasi.php?set=$row[sets]");
      } else{
        $data['cls'] = "ikkehblue";
        $data['btn'] = "<a href='../$url' class='revise-btn btn btn-warning btn-sm pmd-ripple-effect'>Hapus</a>";
      }  
      echo json_encode($data);
  
    }

}