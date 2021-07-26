<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Multi extends MY_Controller {

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
    $this->load->model('model_multi');
    $this->load->library('datatables'); 
  }

  public function index()
  {
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('dataset', 'Tanggal', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        // refresh page
        redirect('multi/getgot/'.$this->input->post('dataset'), 'refresh');
      } 
    }
    // Data untuk page index
    $data['multi'] = $this->db->select('*')
                          ->from('skripsi_analisa')
                          ->group_by('tgl')
                          ->get();
    $data['pageTitle'] = 'Data Batch';
    $data['pageContent'] = $this->load->view('multi/multiList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    error_reporting (E_ALL ^ E_NOTICE);
    // Jika form di submit jalankan blok kode ini
    $analyze = new Analyze();
    //if ($this->input->post('submit')) {
      $this->form_validation->set_rules('file_batch', 'File', 'required');

      $start = microtime(true);

      $file = $this->input->post('file_batch');
      $filename = $file['name'];
      $ext = get_extension($filename);

        $last = $this->db->select('sets')->order_by('sets',"desc")->limit(1)->get('skripsi_analisa');
        foreach ($last->result() as $row){$naruto=$row->sets;}
        if(empty($naruto) or $naruto == 0){
          $sets = 1;
        }
        else{
          $sets = $naruto + 1;
        }
        $tgl = date("Y-m-d H:i:s");
			  $skrg = date("YmdHis");
        
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
            $sentimen[$r] = $analyze->single_process($value); //hasil analisa tersimpan di sini
            $stem[$r] = $analyze->input;
            $nbc[$r] = $analyze->nbc;
            $nbcn[$r] = $analyze->nbcn;
    
    if ($nbc[$r]>$nbcn[$r]) {
      $res = 1;
    } else {
      $res = 0;
    }
    
    $lang[$r] = $res;
    
    
            //$jrk[$r] = $analyze->jarak_hasil_ke_pusat();
    
            $imploded = implode(",",$stem[$r]);
            $data = array(
              'sets' => $sets,
              'tgl' => $tgl,
              'komentar' => $out_text[$r],
              'stem' => $imploded,
              'sentimen' => $res,
            );
            $query = $this->model_multi->insert($data);
    
            $r++;
          }
echo "dddddddddd";
          //endgame
        }

      //}
      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
        $sentimen = $analyze->multi_process($this->input->post('komentar'));
        
        // refresh page
        redirect('multi/add', 'refresh');
      } 
      
    
    // Data untuk page events/add
    $data['r'] = $r;
    $data['stem'] = $stem;
    $data['test'] = $nbcn;
    $data['test2'] = $nbc;
    $data['test3'] = $text;
    $data['lang'] = $lang;
    $data['out_text'] = $out_text;
    $data['pageTitle'] = 'Tambah Data multi';
    $data['pageContent'] = $this->load->view('multi/multiAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_multi = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('sets', 'Tanggal', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {
  
        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
      } 
    }
    
    // Ambil data event dari database
    $multi = $this->model_multi->get_where(array('id_multi' => $id_multi))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$multi) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data multi';
    $data['multi'] = $multi;
    $data['pageContent'] = $this->load->view('multi/multiEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_multi)
  {
    // Ambil data event dari database
    $multi = $this->model_multi->get_where(array('sets' => $id_multi))->row();

    // Jika data event tidak ada maka show 404
    if (!$multi) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_multi->delete($id_multi);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus multi');
    else $message = array('status' => true, 'message' => 'Gagal menghapus multi');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('multi', 'refresh');
  }

  public function pencetan()
  {
        //button
        $dataset = $_GET['dataset'];
        $lengkap = $this->db
                          ->get_where('skripsi_analisa',array('sets'=>$dataset));
        foreach ($lengkap->result() as $k){
          $nucc = $k->sets;
        }
        echo"
          <a href='javascript:void(0);' class='delete_record btn btn-danger' data-toggle='modal' data-target='#modal-konfirmasi' data-code='$nucc'>Delete</a>
          ";
        //end pencetan
  }

  public function salah ()
  {
    if(isset($_GET['id']) and isset($_GET['revise'])){
      $id = intval($_GET['id']);
      $revise = intval($_GET['revise']);
    }
    // Ambil data event dari database
    $multi = $this->model_multi->get_where(array('id' => $id))->row();

    // Jika data event tidak ada maka show 404
    if (!$multi) show_404();

    // Jalankan function delete pada model_events
    $data = array(
      'truesentimen' => $revise,
    );
    $query = $this->model_multi->update($id, $data);

    if($_GET['revise'] == 0){
      $chg = 1;
    }
    else{
      $chg = 0;
    }
    $url = "salah?id=".intval($_GET['id'])."&revise=".intval($chg);
    $data['url'] = $url;

    if($multi->sentimen == $revise){
      $data['cls'] = "";
      $data['btn'] = "<a href='../$url' class='revise-btn btn btn-info btn-sm pmd-ripple-effect'>Tandai sbg kesalahan</a>";
  //		create_alert("Success","Berhasil menghapus tanda kesalahan analisis","../validasi.php?set=$row[sets]");
    }
    else{
      $data['cls'] = "ikkehred";
      $data['btn'] = "<a href='../$url' class='revise-btn btn btn-warning btn-sm pmd-ripple-effect'>Hapus tanda kesalahan</a>";
    }  
    echo json_encode($data);

  }

  function get_json() { //get product data and encode to be JSON object
    header('Content-Type: application/json');
    echo $this->model_multi->get_all();
}

      public function bulk_delete()
    {
        $list_id = $this->input->post('no');
        foreach ($list_id as $id_multi) {
            $this->model_multi->delete_by_id($id_multi);
        }
        echo json_encode(array("status" => TRUE));
    }

    function getgot($id_multi){
      if(isset($_GET['id']) and isset($_GET['revise'])){
        $id = intval($_GET['id']);
        $revise = intval($_GET['revise']);

        $data = array(
          'truesentimen' => $revise,
        );
        $query = $this->model_multi->update($id, $data);
      }

      $lengkap = array();
      $no = 0;
      $lengkap  = $this->db->select('*')
                  ->get_where('skripsi_analisa',array('sets'=>$id_multi));
      $total    = $this->db->select('COUNT(id) as total')
                  ->from('skripsi_analisa')
                  ->where(array('sets' => $id_multi))
                  ->get();
      $tosa     = $this->db->query("SELECT COUNT(id) AS total_salah FROM skripsi_analisa WHERE (truesentimen IS NOT NULL AND sentimen <> truesentimen AND `sets` = $id_multi)");
$data['no'] = $no;
$data['total_data'] = $total;
$data['total_salah'] = $tosa;
$data['lengkap'] = $lengkap;
$data['pageTitle'] = 'Data Analysis';
$data['pageContent'] = $this->load->view('multi/multiEdit', $data, TRUE);

// Jalankan view template/layout
$this->load->view('template/layout', $data);
  }

}