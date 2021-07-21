<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Suara_partai extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Load model events
    $this->load->model('model_suara_partai');
    $this->load->model('model_caleg');
  }

  public function index()
  {
    // Data untuk page index
    $data['pageTitle'] = 'Data Suara Partai';
    $data['pageContent'] = $this->load->view('suara_partai/suara_partaiList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add($id_dapil = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('id_regenc[]', 'Kota', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        $jp = $this->input->post('jsuara_partai');
    $result = array();

    foreach($jp AS $key => $val){
     $result[] = array(
      "jsuara_partai"  => $_POST['jsuara_partai'][$key],
      "id_partai"  => $_POST['id_partai'][$key],
      "id_regenc"  => $_POST['id_regenc1'][$key],
      );
    }

        // Jalankan function insert pada model_events
        $query = $this->db->insert_batch('suara_partai', $result);


        $jc = $this->input->post('jsuara_caleg');
    $result2 = array();

    foreach($jc AS $key => $val){
     $result2[] = array(
      "jsuara_caleg"  => $_POST['jsuara_caleg'][$key],
      "id_calegx"  => $_POST['id_calegx'][$key],
      "id_regenc"  => $_POST['id_regenc'][$key],
      );
    } 

        // Jalankan function insert pada model_events
        $query = $this->db->insert_batch('suara_caleg', $result2);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Harap Konfirmasi Jumlah Kursi');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan suara_partai');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('suara_partai/confirm/'.$id_dapil, 'refresh');
      } 
    }
    
    // Data untuk page events/add
    if ($this->session->userdata('level') == 'administrator') {
      $data['wilayah'] = $this->db->select('*')
                  ->from('regencies')
                  ->where(array('w_dapil' => $id_dapil))
                  ->get();
    } else {
      $data['wilayah'] = $this->db->select('*')
                  ->from('regencies')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('id_regen' => $this->session->userdata('wilayah')))
                  ->get();
    }
        $data['partai'] = $this->db->select('*')
                  ->from('partai')
                  ->where(array('tahun' => '2019'))
                  ->get();
        $data['caleg'] = $this->db->select('*')
                  ->from('caleg')
                  ->where(array('tahun_caleg' => '2019'))
                  ->order_by('CAST(no_urutcal AS DECIMAL(10,6)) ASC')
                  ->get();
        $data['urutan'] = $this->db->select('id_partai')
                  ->from('caleg')
                  ->get();
        $data['suarac'] = $this->db->select('*')->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('no_urutpartai', "asc")
                  ->get();
        $data['suarap'] = $this->db->select('*')->select_sum('jsuara_partai','totalp')
                  ->from('suara_partai')
                  ->join('partai', 'partai.id_partai = suara_partai.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_partai.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('no_urutpartai', "asc")
                  ->get();
    $data['pageTitle'] = 'Tambah Data Suara Partai';
    $data['code'] = $id_dapil;
    $data['pageContent'] = $this->load->view('suara_partai/suara_partaiAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function confirm($id_dapil = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('parpol[]', 'Kota', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

    $party = $this->input->post('parpol[]');
    $result3 = array();

    foreach($party AS $key => $val){
     $result3[] = array(
      "parpol"  => $_POST['parpol'][$key],
      "id_dapil"  => $id_dapil,
      "bpt1"  => $_POST['bpt1'][$key],
      "bpt3"  => $_POST['bpt3'][$key],
      "bpt5"  => $_POST['bpt5'][$key],
      "bpt7"  => $_POST['bpt7'][$key],
      "bpt9"  => $_POST['bpt9'][$key],
      );
    }

$query = $this->db->insert_batch('sainte', $result3);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Harap Konfirmasi Jumlah Kursi');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan suara_partai');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('suara_partai/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
        $data['suarac'] = $this->db->select('*')->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('CAST(no_urutpartai AS DECIMAL(10,6)) ASC')
                  ->get();
        $data['suarap'] = $this->db->select('*')->select_sum('jsuara_partai','totalp')
                  ->from('suara_partai')
                  ->join('partai', 'partai.id_partai = suara_partai.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_partai.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('CAST(no_urutpartai AS DECIMAL(10,6)) ASC')
                  ->get();
    $data['pageTitle'] = 'Validasi Suara Partai';
    $data['code'] = $id_dapil;
    $data['pageContent'] = $this->load->view('suara_partai/suara_partaiConfirm', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

    public function result($id_dapil = null)
  {    
    // Data untuk page events/add
        $data['suarap'] = $this->db->select('*')->select_sum('jsuara_partai','totalp')
                  ->from('suara_partai')
                  ->join('partai', 'partai.id_partai = suara_partai.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_partai.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('CAST(no_urutpartai AS DECIMAL(10,6)) ASC')
                  ->get();
        $data['total'] = $this->db->select('*')->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $id_dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->group_by('partai.id_partai')
                  ->order_by('CAST(no_urutpartai AS DECIMAL(10,6)) ASC')
                  ->get();
        $data['winner'] = $this->db->query("select parpol,`id_dapil`, count(*) AS hitung from 
(
    SELECT distinct `bpt1`,`parpol`,`id_dapil` FROM sainte
UNION ALL
SELECT `bpt3`,`parpol`,`id_dapil` FROM sainte
UNION
SELECT `bpt5`,`parpol`,`id_dapil` FROM sainte
UNION
SELECT `bpt7`,`parpol`,`id_dapil` FROM sainte
UNION
SELECT `bpt9`,`parpol`,`id_dapil` FROM sainte
ORDER BY `bpt1` DESC
LIMIT 10) as a GROUP BY `parpol`");

    $data['pageTitle'] = 'Hasil Perhitungan';
    $data['dapil'] = $id_dapil;
    $data['pie_data'] = $this->model_suara_partai->GetPie();
    $data['pageContent'] = $this->load->view('suara_partai/suara_partaiHitung', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }


  public function edit($id_suara_partai = null)
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('nama_suara_partai', 'Nama', 'required');
      $this->form_validation->set_rules('no_urutsuara_partai', 'suara_partai', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

      if (!empty($_FILES['lambang']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = $id_suara_partai.'_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('lambang')) {
            exit($this->upload->display_errors());
        }
$data = array('lambang' => $this->upload->data()['file_name'],);
$query = $this->model_suara_partai->update($id_suara_partai, $data);
        //$data['avatar'] = $this->upload->data()['file_name'];
      }

        $data = array(
          'no_urutsuara_partai' => $this->input->post('no_urutsuara_partai'),
          'nama_suara_partai' => $this->input->post('nama_suara_partai'),
          'akronim' => $this->input->post('akronim'),
          'tahun' => $this->input->post('tahun'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_suara_partai->update($id_suara_partai, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui suara_partai');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui suara_partai');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('suara_partai/edit/'.$id_suara_partai, 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $suara_partai = $this->model_suara_partai->get_where(array('id_suara_partai' => $id_suara_partai))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$suara_partai) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data Suara Partai';
    $data['suara_partai'] = $suara_partai;
    $data['wilayah'] = $wilayah;
    $data['pageContent'] = $this->load->view('suara_partai/suara_partaiEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

        function w_json(){

        $this->load->library('datatables');
        $this->datatables->select('id_dapil,nama_dapil,kursi');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="suara_partai/add/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-plus-square"></i> </a> </div>','id_dapil');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_dapil');

            $this->datatables->from('dapil');

            if ($this->session->userdata('level') == 'administrator') {
              $this->datatables->from('dapil');
            } else {
              $this->datatables->from('dapil')
                               ->where('id_dapil', $this->session->userdata('w_dapil'));
            }
    
        return print_r($this->datatables->generate());
    }

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_suara_partai');
        foreach ($list_id as $id_suara_partai) {
            $this->model_suara_partai->delete_by_id($id_suara_partai);
        }
        echo json_encode(array("status" => TRUE));
    }

}