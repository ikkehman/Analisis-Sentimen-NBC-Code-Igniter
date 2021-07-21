<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Caleg extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Load model events
    $this->load->model('model_caleg');
  }

  public function index()
  {
    // Data untuk page index
    $data['pageTitle'] = 'Data Caleg';
    $data['pageContent'] = $this->load->view('caleg/calegList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('nama', 'Nama', 'required');

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('id_partai', 'Partai', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

                        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $config['file_name'] = 'IMG_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('foto_caleg')) {
            exit($this->upload->display_errors());
        }

        $data = array(
          'nama' => $this->input->post('nama'),
          'tg_lahir' => date("Y-m-d", strtotime($this->input->post('tg_lahir'))),
          'no_urutcal' => $this->input->post('no_urutcal'),
          'id_partai' => $this->input->post('id_partai'),
          'dapil' => $this->input->post('dapil'),
          'tp_lahir' => $this->input->post('tp_lahir'),
          'jk' => $this->input->post('jk'),
          'agama' => $this->input->post('agama'),
          'alamat' => $this->input->post('alamat'),
          'status_kawin' => $this->input->post('status_kawin'),
          'pend' => $this->input->post('pend'),
          'motivasi' => $this->input->post('motivasi'),
          'target' => $this->input->post('target'),
          'tahun_caleg' => $this->input->post('tahun_caleg'),
          'foto_caleg' => $this->upload->data()['file_name'],
        );

        // Jalankan function insert pada model_events
        $query = $this->model_caleg->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan caleg');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan caleg');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('caleg/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
        $data['partai'] = $this->db->select('*')
                  ->from('partai')
                  ->get();
        $data['dapil'] = $this->db->select('*')
                  ->from('dapil')
                  ->get();
    $data['pageTitle'] = 'Tambah Data caleg';
    $data['pageContent'] = $this->load->view('caleg/calegAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_caleg = null)
  {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('nama', 'Nama', 'required');

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('id_partai', 'Partai', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        if (!empty($_FILES['foto_caleg']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2000;
        $config['file_name'] = 'IMG_'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('foto_caleg')) {
            exit($this->upload->display_errors());
        }
$data = array('foto_caleg' => $this->upload->data()['file_name'],);
$query = $this->model_caleg->update($id_caleg, $data);
      }

        $data = array(
          'nama' => $this->input->post('nama'),
          'tg_lahir' => date("Y-m-d", strtotime($this->input->post('tg_lahir'))),
          'no_urutcal' => $this->input->post('no_urutcal'),
          'id_partai' => $this->input->post('id_partai'),
          'dapil' => $this->input->post('dapil'),
          'tp_lahir' => $this->input->post('tp_lahir'),
          'jk' => $this->input->post('jk'),
          'agama' => $this->input->post('agama'),
          'alamat' => $this->input->post('alamat'),
          'status_kawin' => $this->input->post('status_kawin'),
          'pend' => $this->input->post('pend'),
          'motivasi' => $this->input->post('motivasi'),
          'target' => $this->input->post('target'),
          'tahun_caleg' => $this->input->post('tahun_caleg'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_caleg->update($id_caleg, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui caleg');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui caleg');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('caleg/edit/'.$id_caleg, 'refresh');
      } 
    
    
    // Ambil data event dari database
    $caleg = $this->model_caleg->get_where(array('id_caleg' => $id_caleg))->row();
    $tambahan = $this->model_caleg->tambahan(array('id_caleg' => $id_caleg))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$caleg) show_404();

    // Data untuk page events/add
    $data['partai'] = $this->db->select('*')
                  ->from('partai')
                  ->get();
    $data['dapil'] = $this->db->select('*')
                  ->from('dapil')
                  ->get();
    $data['pageTitle'] = 'Edit Data caleg';
    $data['caleg'] = $tambahan;
    $data['pageContent'] = $this->load->view('caleg/calegEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_caleg)
  {
    // Ambil data event dari database
    $caleg = $this->model_caleg->get_where(array('id_caleg' => $id_caleg))->row();

    // Jika data event tidak ada maka show 404
    if (!$caleg) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_caleg->delete($id_caleg);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus caleg');
    else $message = array('status' => true, 'message' => 'Gagal menghapus caleg');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('caleg', 'refresh');
  }

    function json(){

        $this->load->library('datatables');
        $this->datatables->select('id_caleg,nama,no_urutcal,nama_partai,nama_dapil,jk');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="caleg/edit/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-edit"></i> </a> <a href="javascript:;" data-toggle="modal" title="" class="btn btn-link btn-danger" data-target="#modal-konfirmasi" data-original-title="Remove" data-id="$1"> <i class="la la-times"></i> </a> </div>','id_caleg');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_caleg');

            $this->datatables->from('caleg')
                             ->join('partai', 'partai.id_partai = caleg.id_partai')
                             ->join('dapil', 'dapil.id_dapil = caleg.dapil');
    
        return print_r($this->datatables->generate());
    }

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_caleg');
        foreach ($list_id as $id_caleg) {
            $this->model_caleg->delete_by_id($id_caleg);
        }
        echo json_encode(array("status" => TRUE));
    }

}