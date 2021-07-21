<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    
    // Cek apakah event sudah login
    $this->cekLogin();

    // Load model events
    $this->load->model('model_surat');
  }

  public function index()
  {
 // Load library pagination
    $this->load->library('pagination');

    // Pengaturan pagination
    $config['base_url'] = base_url('surat/index/');
    $config['total_rows'] = $this->model_surat->get()->num_rows();
    $config['per_page'] = 10;
    $config['offset'] = $this->uri->segment(3);

    // Styling pagination
    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['full_tag_open'] = '<ul class="pagination pg-primary">';
    $config['full_tag_close'] = '</ul>';

    $config['num_tag_open'] = '<li class="page-item"><a class="page-link"';
    $config['num_tag_close'] = '</a></li>';

    $config['prev_tag_open'] = '<li class="page-item"><a class="page-link"';
    $config['prev_tag_close'] = '</a></li>';

    $config['next_tag_open'] = '<li class="page-item"><a class="page-link"';
    $config['next_tag_close'] = '</a></li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);

    // Data untuk page index
    $data['pageTitle'] = 'Surat';

    if ($this->session->userdata('level') == 'administrator') {
      $data['surat'] = $this->model_surat->get_surat($config['per_page'], $config['offset'])->result();
    } else {
      $data['surat'] = $this->model_surat->get_suratx($config['per_page'], $config['offset'])->result();
    }

    $data['pageContent'] = $this->load->view('surat/suratList', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function add()
  {
    $this->isKepalaSuku();
    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('dari', 'Pengirim', 'required');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        // Konfigurasi library upload codeigniter
        $config['upload_path'] = './assets/attachment';
        $config['allowed_types'] = 'xls|xlsx|pdf|docx|doc';
        $config['max_size'] = 2000;

        // Load library upload
        $this->load->library('upload', $config);
        
        // Jika terdapat error pada proses upload maka exit
        if (!$this->upload->do_upload('lamp')) {
            exit($this->upload->display_errors());
        }

        $data = array(
          'dari' => $this->input->post('dari'),
          'no_pelang' => $this->input->post('no_pelang'),
          'perihal' => $this->input->post('perihal'),
          'isi' => $this->input->post('isi',FALSE),
          'lamp' => $this->upload->data()['file_name'],
          'baca' => 'unread',
        );

        // Jalankan function insert pada model_events
        $query = $this->model_surat->insert($data);

        $penomoran = $this->db->select('*')
                  ->limit(1)
                  ->order_by('id_surat', 'DESC')
                  ->get('surat')
                  ->row();

        $data = array(
          'tujuan' => $this->input->post('tujuan'),
          'no_surat' => $penomoran->id_surat,
        );

        $query = $this->model_surat->insert_disposisi($data);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan surat');
        else $message = array('status' => true, 'message' => 'Gagal menambahkan surat');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
        redirect('surat/add', 'refresh');
      } 
    }
    
    // Data untuk page events/add
    switch ($this->session->userdata('level')) {

          case 'kabid':
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'kupt'))
                  ->get();
            break;

            case 'kupt':
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'pengawas'))
                  ->get();
            break;

          default:
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'kabid'))
                  ->get();
            break;
        }

    $data['pelanggaran'] = $this->db->select('*')
                  ->from('pelanggaran')
                  ->join('perusahaan', 'perusahaan.id_perusahaan = pelanggaran.peru_pela')
                  ->join('norma', 'norma.id_norma = pelanggaran.norma')
                  ->get();
    $data['pageTitle'] = 'Tambah Data surat';
    $data['pageContent'] = $this->load->view('surat/suratAdd', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function lihat($id_surat = null)
  {

        // Ambil data event dari database
    $surat = $this->model_surat->get_where(array('id_surat' => $id_surat))->row();

    // Jika data event tidak ada maka show 404
    if (!$surat) show_404();

    if ($this->session->userdata('level') !== 'administrator') {
      $data = array(
      'baca' => 'read',
    );

    // Jalankan function insert pada model_events
    $query = $this->model_surat->update($id_surat, $data);
    }

    // Jika form di submit jalankan blok kode ini
    if ($this->input->post('submit')) {

      // Mengatur validasi data tanggal mulai,
      // # required = tidak boleh kosong
      $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');

      // Mengatur pesan error validasi data
      $this->form_validation->set_message('Tujuan', '%s tidak boleh kosong!');

      // Jalankan validasi jika semuanya benar maka lanjutkan
      if ($this->form_validation->run() === TRUE) {

        
$data3 = array(
      'status' => 'Disposisi',
    );

    // Jalankan function insert pada model_events
    $query = $this->model_surat->update_dis($id_surat, $data3);

        $data = array(
          'tujuan' => $this->input->post('tujuan'),
          'ket' => $this->input->post('ket'),
          'no_surat' => $id_surat,
        );

        // Jalankan function insert pada model_events
        $query = $this->model_surat->insert_disposisi($data);

        $data2 = array(
      'baca' => 'unread',

    );

    // Jalankan function insert pada model_events
    $query = $this->model_surat->update($id_surat, $data2);

        // cek jika query berhasil
        if ($query) $message = array('status' => true, 'message' => 'Berhasil disposisi surat');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui surat');

        // simpan message sebagai session
        $this->session->set_flashdata('message', $message);

        // refresh page
    redirect('surat', 'refresh');
      } 
    }
    
    // Ambil data event dari database
    $surat = $this->model_surat->get_where(array('id_surat' => $id_surat))->row();
    $tambahan = $this->model_surat->tambahan(array('id_surat' => $id_surat))->row();
    $ikkeh=$this->db
            ->select('lamp')
            ->from('surat')
            ->where('id_surat',$id_surat)->get();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    

    // Jika data event tidak ada maka show 404
    if (!$surat) show_404();

    // Data untuk page events/add
    switch ($this->session->userdata('level')) {

          case 'kabid':
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'kupt'))
                  ->get();
            break;

            case 'kupt':
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'pengawas'))
                  ->get();
            break;

          default:
            $data['pengawas'] = $this->db->select('*')
                  ->from('users')
                  ->where(array('level' => 'kabid'))
                  ->get();
            break;
        }
    $data['hitung'] = $this->db
            ->select('lamp')
            ->from('surat')
            ->where('id_surat',$id_surat)->get();
    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data surat';
    $data['surat'] = $tambahan;
    $data['pageContent'] = $this->load->view('surat/suratEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_surat)
  {
    $this->isKepalaSuku();
    // Ambil data event dari database
    $surat = $this->model_surat->get_where(array('id_surat' => $id_surat))->row();

    // Jika data event tidak ada maka show 404
    if (!$surat) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_surat->delete($id_surat);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus surat');
    else $message = array('status' => true, 'message' => 'Gagal menghapus surat');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('surat', 'refresh');
  }

    function json(){

        $this->load->library('datatables');
        $this->datatables->select('id_surat,users.nama as pengirim,u1.nama as penerima,tanggal,perihal,baca');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="surat/edit/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-edit"></i> </a> <a href="javascript:;" data-toggle="modal" title="" class="btn btn-link btn-danger" data-target="#modal-konfirmasi" data-original-title="Remove" data-id="$1"> <i class="la la-times"></i> </a> </div>','id_surat');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_surat');

        switch ($this->session->userdata('level')) {

          case 'kawil I':
            $this->datatables->from('surat')
                             ->join('users', 'users.username = surat.dari')
                             ->join('users as u1', 'u1.username = surat.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;

            case 'kawil II':
            $this->datatables->from('surat')
                             ->join('users', 'users.username = surat.dari')
                             ->join('users as u1', 'u1.username = surat.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;

            case 'kawil III':
            $this->datatables->from('surat')
                             ->join('users', 'users.username = surat.dari')
                             ->join('users as u1', 'u1.username = surat.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;
          
          default:
            $this->datatables->from('surat')
                             ->join('users', 'users.username = surat.dari')
                             ->join('users as u1', 'u1.username = surat.tujuan');
            break;
        }

    
        return print_r($this->datatables->generate());
    }

   public function cari()
       {
 
            //mengambil nilai keyword dari form pencarian
     $search = (trim($this->input->post('key',true)))? trim($this->input->post('key',true)) : '';
 
     //jika uri segmen 3 ada, maka nilai variabel $search akan diganti dengan nilai uri segmen 3
     $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
 
     //mengambil nilari segmen 4 sebagai offset
            $dari      = $this->uri->segment('4');
 
            //limit data yang ditampilkan
            $sampai = 10;
 
            //inisialisasi variabel $like
            $like      = '';
 
            //mengisi nilai variabel $like dengan variabel $search, digunakan sebagai kondisi untuk menampilkan data

    if ($this->session->userdata('level') === 'administrator') {
      if($search) $like = "(isi LIKE '%$search%' or perihal LIKE '%$search%' or users.nama LIKE '%$search%' or u1.nama LIKE '%$search%')";
    } else {
      if($search) $like = "(isi LIKE '%$search%' or perihal LIKE '%$search%' or users.nama LIKE '%$search%' && u1.nama = $this->session->userdata('nama'))";
    }

            //hitung jumlah row
            $jumlah= $this->model_surat->jumlah($like);

            if (!$search) redirect('surat','refresh');;

            //inisialisasi array
            $config = array();
 
            //set base_url untuk setiap link page
            $config['base_url'] = base_url().'surat/cari/'.$search;
 
            //hitung jumlah row
           $config['total_rows'] = $jumlah;
 
           //mengatur total data yang tampil per page
           $this->load->library('pagination');
           $config['per_page'] = $sampai;
 
           //mengatur jumlah nomor page yang tampil
           $config['num_links'] = $jumlah;
           $config['first_link'] = false;
           $config['last_link'] = false;

           $config['full_tag_open'] = '<ul class="pagination pg-primary">';
           $config['full_tag_close'] = '</ul>';

           $config['num_tag_open'] = '<li class="page-item"><a class="page-link"';
           $config['num_tag_close'] = '</a></li>';

           $config['prev_tag_open'] = '<li class="page-item"><a class="page-link"';
           $config['prev_tag_close'] = '</a></li>';

           $config['next_tag_open'] = '<li class="page-item"><a class="page-link"';
           $config['next_tag_close'] = '</a></li>';

           $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
           $config['cur_tag_close'] = '</a></li>';
 
           //inisialisasi array 'config' dan set ke pagination library
           $this->pagination->initialize($config);
           
           //inisialisasi array
            $data = array();
 
            //ambil data buku dari database
           $data['surat'] = $this->model_surat->lihat($sampai, $dari, $like);
           $data['pageTitle'] = 'Surat';
           $data['search'] = $search;
           //Membuat link
           $data['pageContent'] = $this->load->view('surat/suratSearch', $data, TRUE);

    // Jalankan view template/layout
           $this->load->view('template/layout', $data);
      }

      public function bulk_delete()
    {
    $this->isKepalaSuku();
        $list_id = $this->input->post('id_surat');
        foreach ($list_id as $id_surat) {
            $this->model_surat->delete_by_id($id_surat);
        }
    $message = array('status' => true, 'message' => 'Berhasil menghapus surat');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    }

}