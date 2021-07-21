<?php
  class Model_surat extends CI_Model {

    public $table = 'surat';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_surat($limit, $offset)
    {
      // Jalankan query
      $query = $this->db
        ->select('id_surat,users.nama as pengirim, u1.nama as penerima,tanggal,perihal,baca,isi,lamp,users.avatar as foto,u1.username as u_penerima,tanggal_dis')
        ->join('users', 'users.username = surat.dari')
        ->join('disposisi', 'disposisi.no_surat = surat.id_surat')
        ->join('users as u1', 'u1.username = disposisi.tujuan')
        ->limit($limit, $offset)
        ->group_by('id_surat')
        ->order_by('tanggal', 'DESC')
        ->get($this->table);
      // Return hasil query
      return $query;
    }

    public function get_suratx($limit, $offset)
    {
      // Jalankan query
      $query = $this->db
        ->select('id_surat,users.nama as pengirim, u1.nama as penerima,tanggal,perihal,baca,isi,lamp,users.avatar as foto,u1.username as u_penerima,tanggal_dis,status')
        ->join('users', 'users.username = surat.dari')
        ->join('disposisi', 'disposisi.no_surat = surat.id_surat')
        ->join('users as u1', 'u1.username = disposisi.tujuan')
        ->limit($limit, $offset)
        ->order_by('tanggal', 'DESC')
        ->where('tujuan', $this->session->userdata('username'))
        ->where('status', 'Belum Disposisi')
        ->get($this->table);
      // Return hasil query
      return $query;
    }

    public function get_where($where)
    {
      // Jalankan query
      $query = $this->db
        ->where($where)
        ->get($this->table);

      // Return hasil query
      return $query;
    }

    public function insert($data)
    {
      // Jalankan query
      $query = $this->db->insert($this->table, $data);

      // Return hasil query
      return $query;
    }

    public function insert_disposisi($data)
    {
      // Jalankan query
      $query = $this->db->insert('disposisi', $data);

      // Return hasil query
      return $query;
    }

    public function update($id_surat, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_surat', $id_surat)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function update_dis($id_surat, $data)
    {
      // Jalankan query
      $query = $this->db
        ->select('id_disposisi')
        ->where('no_surat', $id_surat)
        ->order_by('id_disposisi', 'DESC')
        ->limit(1)
        ->update('disposisi', $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_surat)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_surat', $id_surat)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_surat)
    {
        $this->db->where('id_surat', $id_surat)
        ->delete($this->table);
    }
    
    public function tambahan($where)
    {
      // Jalankan query
      $query= $this->db->select('id_surat,users.nama as pengirim, u1.nama as penerima,tanggal,perihal,baca,isi,lamp,users.avatar as foto,users.level as level_s, u1.level as level_p,nama_perusahaan,nama_norma,tgl_pelang,tanggal_dis')
                  ->from('surat')
                  ->join('users', 'users.username = surat.dari')
                  ->join('disposisi', 'disposisi.no_surat = surat.id_surat')
                  ->join('users as u1', 'u1.username = disposisi.tujuan')
                  ->join('pelanggaran', 'pelanggaran.id_pelanggaran = surat.no_pelang')
                  ->join('perusahaan', 'perusahaan.id_perusahaan = pelanggaran.peru_pela')
                  ->join('norma', 'norma.id_norma = pelanggaran.norma')
                  ->where($where)
                  ->order_by('tanggal_dis', 'DESC')
                  ->get();

      // Return hasil query
      return $query;
    }

  //hitung jumlah row
  function jumlah($like=''){
   
   if($like)
    $this->db
    ->join('users', 'users.username = surat.dari')
    ->join('disposisi', 'disposisi.no_surat = surat.id_surat')
    ->join('users as u1', 'u1.username = disposisi.tujuan')
    ->where($like);
     
   $query = $this->db->get('surat');
   return $query->num_rows();
  }

  public function lihat($sampai, $dari, $like = ''){
 
   if($like)

    $this->db
    ->join('users', 'users.username = surat.dari')
    ->join('disposisi', 'disposisi.no_surat = surat.id_surat')
    ->join('users as u1', 'u1.username = disposisi.tujuan')
    ->where($like);
 
   $query = $this->db->select('id_surat,users.nama as pengirim, u1.nama as penerima,tanggal,perihal,baca,isi,lamp,users.avatar as foto')
        ->get('surat',$sampai,$dari);
   return $query->result_array();
  }

  }