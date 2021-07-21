<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumentasi extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // Load model events
    $this->load->model('model_dokumentasi');
  }

  public function index()
  {
            // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();
    // Data untuk page index
    $data['pageTitle'] = 'Dokumentasi';
    $data['pageContent'] = $this->load->view('dokumentasi/dokumentasiList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

    public function saveGambar()
  {
         if(isset($_FILES["file"]["name"]))  
     {  
          $config['upload_path'] = './assets/img/';  
          $config['allowed_types'] = 'jpg|jpeg|png|gif';  
          $this->load->library('upload', $config);  
          if(!$this->upload->do_upload('file'))  
          {  
               $this->upload->display_errors();  
               return FALSE;
          }  
          else  
          {  
               $data = $this->upload->data();                 
                echo base_url().'assets/img/'.$_FILES['file']['name'];                                     
          }  
     } 

  }

  public function add()
  {

        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    $data = array ('success' => false, 'messages' => array());

    $this->load->library('form_validation');
    $this->form_validation->set_rules('judul', 'Judul', 'trim|required|min_length[5]');          
    $this->form_validation->set_rules('konten', 'Konten', 'required|min_length[10]');    
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


    if($this->form_validation->run()) {     

        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|';
        $config['max_size'] = 2000;
        $config['file_name'] = 'img'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('featured_img')) {
            exit($this->upload->display_errors());
        }

        $data1 = array (
            'judul' => $this->input->post('judul'),
            'konten' => $this->input->post('konten', FALSE),
            'author' => $this->session->userdata('username'),
            'featured_img' => $this->upload->data()['file_name'],            
          );
        $query=$this->model_dokumentasi->insert($data1);
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan Dokumentasi');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan Dokumentasi');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);
        
      $data['success'] = true;

    } else {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }     

    }
    echo json_encode($data);

    // Data untuk page events/add
    $data['pageTitle'] = 'Tambah Data dokumentasi ';
    $data['pageContent'] = $this->load->view('dokumentasi/dokumentasiAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

    public function post($id_dokumentasi = null)
  {
    
    // Ambil data event dari database
    $dokumentasi = $this->model_dokumentasi->get_where(array('id_dokumentasi' => $id_dokumentasi))->row();

    // Jika data event tidak ada maka show 404
    if (!$dokumentasi) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data dokumentasi';
    $data['dokumentasi'] = $dokumentasi;
    $data['pageContent'] = $this->load->view('home/home_post', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/blog_layout', $data);
  }

  public function edit($id_dokumentasi = null)
  {


        // Cek apakah event sudah login
    $this->cekLogin();
    
    // Cek apakah user login 
    // sebagai administrator
    $this->isKepalaSuku();

    $data = array ('success' => false, 'messages' => array());

    $this->load->library('form_validation');
    $this->form_validation->set_rules('judul', 'Judul', 'trim|required|min_length[5]');           
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


    if($this->form_validation->run()) {     

      if (!empty($_FILES['featured_img']['name'])) {
        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2000;
        $config['file_name'] = 'img'.date('YmdHis');

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('featured_img')) {
            exit($this->upload->display_errors());
        }
$data1 = array('featured_img' => $this->upload->data()['file_name'],);
$query = $this->model_dokumentasi->update($id_dokumentasi, $data1);
      }

        $data1 = array (
            'judul' => $this->input->post('judul'),
            'konten' => $this->input->post('konten', FALSE),
            'author' => $this->session->userdata('username'),           
          );
        $query = $this->model_dokumentasi->update($id_dokumentasi, $data1);

        if ($query) $message = array('status' => true, 'message' => 'Berhasil mengedit Dokumentasi');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan Dokumentasi');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);
        
      $data['success'] = true;

    } else {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }     

    }
    echo json_encode($data);
    
    // Ambil data event dari database
    $dokumentasi = $this->model_dokumentasi->get_where(array('id_dokumentasi' => $id_dokumentasi))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$dokumentasi) show_404();

    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data dokumentasi';
    $data['dokumentasi'] = $dokumentasi;
    $data['pageContent'] = $this->load->view('dokumentasi/dokumentasiEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_dokumentasi)
  {
    $this->isKepalaSuku();
    // Ambil data event dari database
    $dokumentasi = $this->model_dokumentasi->get_where(array('id_dokumentasi' => $id_dokumentasi))->row();

    // Jika data event tidak ada maka show 404
    if (!$dokumentasi) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_dokumentasi->delete($id_dokumentasi);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus dokumentasi');
    else $message = array('status' => true, 'message' => 'Gagal menghapus dokumentasi');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('dokumentasi', 'refresh');
  }

      function json(){

        $this->load->library('datatables');
        $this->datatables->select('id_dokumentasi,judul,tanggal_rilis,author');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="dokumentasi/edit/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-edit"></i> </a> <a href="javascript:;" data-toggle="modal" title="" class="btn btn-link btn-danger" data-target="#modal-konfirmasi" data-original-title="Remove" data-id="$1"> <i class="la la-times"></i> </a> </div>','id_dokumentasi');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_dokumentasi');

            $this->datatables->from('dokumentasi');
    
        return print_r($this->datatables->generate());
    }

      public function bulk_delete()
    {
        $list_id = $this->input->post('id_dokumentasi');
        foreach ($list_id as $id_dokumentasi) {
            $this->model_dokumentasi->delete_by_id($id_dokumentasi);
        }
        echo json_encode(array("status" => TRUE));
    }


}