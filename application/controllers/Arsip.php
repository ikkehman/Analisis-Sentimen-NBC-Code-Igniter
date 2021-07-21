<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // Load model events
    $this->load->model('model_arsip');
  }

  public function index()
  {
    // Load library pagination
    $this->load->library('pagination');

    // Pengaturan pagination
    $config['base_url'] = base_url('arsip/index/');
    $config['total_rows'] = $this->model_arsip->get()->num_rows();
    $config['per_page'] = 9999;
    $config['offset'] = $this->uri->segment(3);

    // Styling pagination
    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    $config['num_tag_open'] = '<li class="waves-effect">';
    $config['num_tag_close'] = '</li>';

    $config['prev_tag_open'] = '<li class="waves-effect">';
    $config['prev_tag_close'] = '</li>';

    $config['next_tag_open'] = '<li class="waves-effect">';
    $config['next_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);

    // Data untuk page index
    $data['pageTitle'] = 'arsip';
    $data['arsip'] = $this->model_arsip->get_arsip($config['per_page'], $config['offset'])->result();
    $data['pageContent'] = $this->load->view('home/home_archive', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/blog_layout', $data);
  }

  public function data()
  {
    // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Data untuk page index
    $data['pageTitle'] = 'Data Arsip';
    $data['pageContent'] = $this->load->view('arsip/arsipList', $data, TRUE);

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
      $this->form_validation->set_rules('kategori', 'kategori', 'required');

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('tahun_docs', 'Tahun', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

                // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
        $config['max_size'] = 10000;
        $config['file_name'] = 'dokumen'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('file')) {
            exit($this->upload->display_errors());
        }

        $data = array(
          'nama_docs' => $this->input->post('nama_docs'),
          'kategori' => $this->input->post('kategori'),
          'tahun_docs' => $this->input->post('tahun_docs'),
          'file' => $this->upload->data()['file_name'],

        );

        // Jalankan function insert pada model_events
        $query = $this->model_arsip->insert($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan Dokumen');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan Dokumen');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('arsip/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
    $data['pageTitle'] = 'Tambah Data arsip';
    $data['pageContent'] = $this->load->view('arsip/arsipAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function edit($id_arsip = null)
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
      $this->form_validation->set_rules('kategori', 'kategori', 'required');

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('tahun_docs', 'Tahun', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

      if (!empty($_FILES['file']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
        $config['max_size'] = 10000;
        $config['file_name'] = 'dokumen'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('file')) {
            exit($this->upload->display_errors());
        }
        $data = array('file' => $this->upload->data()['file_name'],);
        $query = $this->model_arsip->update($id_arsip, $data);
      }


        $data = array(
          'nama_docs' => $this->input->post('nama_docs'),
          'kategori' => $this->input->post('kategori'),
          'tahun_docs' => $this->input->post('tahun_docs'),
        );

        // Jalankan function insert pada model_events
        $query = $this->model_arsip->update($id_arsip, $data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui arsip');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui arsip');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        //redirect('arsip/edit/'.$id_arsip, 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $arsip = $this->model_arsip->get_where(array('id_arsip' => $id_arsip))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$arsip) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data arsip';
    $data['arsip'] = $arsip;
    $data['pageContent'] = $this->load->view('arsip/arsipEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_arsip)
  {
        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    // Ambil data event dari database
    $arsip = $this->model_arsip->get_where(array('id_arsip' => $id_arsip))->row();

    // Jika data event tidak ada maka show 404
    if (!$arsip) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_arsip->delete($id_arsip);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus arsip');
    else $message = array('status' => true, 'message' => 'Gagal menghapus arsip');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('arsip/data', 'refresh');

  }
      function json(){

        $this->load->library('datatables');
        $this->datatables->select('id_arsip,nama_docs,kategori,tahun_docs,file');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="./edit/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-edit"></i> </a> <a href="javascript:;" data-toggle="modal" title="" class="btn btn-link btn-danger" data-target="#modal-konfirmasi" data-original-title="Remove" data-id="$1"> <i class="la la-times"></i> </a> </div>','id_arsip');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_arsip');

            $this->datatables->from('dokumen');
    
        return print_r($this->datatables->generate());
    }

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_arsip');
        foreach ($list_id as $id_arsip) {
            $this->model_arsip->delete_by_id($id_arsip);
        }
        echo json_encode(array("status" => TRUE));
    }


}