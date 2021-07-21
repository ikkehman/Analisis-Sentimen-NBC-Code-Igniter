<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function __construct()
  {
    parent::__construct();


    // Load model events
    $this->load->model('model_dokumentasi');
  }

  public function index()
  {

        // Load library pagination
    $this->load->library('pagination');

    // Pengaturan pagination
    $config['base_url'] = base_url('home/index/');
    $config['total_rows'] = $this->model_dokumentasi->get()->num_rows();
    $config['per_page'] = 6;
    $config['offset'] = $this->uri->segment(3);

    // Styling pagination
    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    $config['num_tag_open'] = '<li class="page-item page-link">';
    $config['num_tag_close'] = '</li>';

    $config['prev_tag_open'] = '<li class="page-item page-link">';
    $config['prev_tag_close'] = '</li>';

    $config['next_tag_open'] = '<li class="page-item page-link">';
    $config['next_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);

    // Data untuk page index
    $data['dapil'] = $this->db->select('*')
                  ->from('dapil')
                  ->get();
    $data['pageTitle'] = 'berita';
    $data['dokumentasi'] = $this->model_dokumentasi->get_dokumentasi($config['per_page'], $config['offset'])->result();
    $data['pageContent'] = $this->load->view('home/home_def', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/blog_layout', $data);
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
    $data['pageContent'] = $this->load->view('home/home_result', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/blog_layout', $data);
  }
  public function lihat($id_berita = null)
  {
    
    // Ambil data event dari database
    $berita = $this->model_dokumentasi->get_where(array('id_dokumentasi' => $id_berita))->row();

    // Mengubah format tanggal dari database
    //$kejuruan->priode = date_format(date_create($kejuruan->priode), 'd-m-Y');
    
    // Data untuk page events/add
    $data['pageTitle'] = 'Edit Data berita';
    $data['berita'] = $tambahan;
    $data['pageContent'] = $this->load->view('berita/beritaEdit', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/layout', $data);
  }

  public function delete($id_berita)
  {
    $this->isPengawas();
    // Ambil data event dari database
    $berita = $this->model_berita->get_where(array('id_berita' => $id_berita))->row();

    // Jika data event tidak ada maka show 404
    if (!$berita) show_404();

    // Jalankan function delete pada model_events
    $query = $this->model_berita->delete($id_berita);

    // cek jika query berhasil
    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus berita');
    else $message = array('status' => true, 'message' => 'Gagal menghapus berita');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    // refresh page
    redirect('berita', 'refresh');
  }

    function json(){

        $this->load->library('datatables');
        $this->datatables->select('id_berita,users.nama as pengirim,u1.nama as penerima,tanggal,perihal,baca');
        $this->datatables->add_column('edit', '<div class="form-button-action"> <a href="berita/edit/$1" id="edit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Edit Task"> <i class="la la-edit"></i> </a> <a href="javascript:;" data-toggle="modal" title="" class="btn btn-link btn-danger" data-target="#modal-konfirmasi" data-original-title="Remove" data-id="$1"> <i class="la la-times"></i> </a> </div>','id_berita');
        $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_berita');

        switch ($this->session->userdata('level')) {

          case 'kawil I':
            $this->datatables->from('berita')
                             ->join('users', 'users.username = berita.dari')
                             ->join('users as u1', 'u1.username = berita.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;

            case 'kawil II':
            $this->datatables->from('berita')
                             ->join('users', 'users.username = berita.dari')
                             ->join('users as u1', 'u1.username = berita.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;

            case 'kawil III':
            $this->datatables->from('berita')
                             ->join('users', 'users.username = berita.dari')
                             ->join('users as u1', 'u1.username = berita.tujuan')
                             ->where('tujuan', $this->session->userdata('username'));
            break;
          
          default:
            $this->datatables->from('berita')
                             ->join('users', 'users.username = berita.dari')
                             ->join('users as u1', 'u1.username = berita.tujuan');
            break;
        }

    
        return print_r($this->datatables->generate());
    }

      public function bulk_delete()
    {
    $this->isKepalaSuku();
        $list_id = $this->input->post('id_berita');
        foreach ($list_id as $id_berita) {
            $this->model_berita->delete_by_id($id_berita);
        }
    $message = array('status' => true, 'message' => 'Berhasil menghapus berita');

    // simpan message sebagai session
    $this->session->set_flashdata('message', $message);

    }

      public function contact()
  {
    // Data untuk page index
    $data['pageTitle'] = 'contact';
    $data['pageContent'] = $this->load->view('home/home_contact', $data, TRUE);

    // Jalankan view template/layout
    $this->load->view('template/blog_layout', $data);
  }
}