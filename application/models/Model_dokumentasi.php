<?php
  class Model_dokumentasi extends CI_Model {

    public $table = 'dokumentasi';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_dokumentasi($limit, $offset)
    {
      // Jalankan query
      $query = $this->db
        ->limit($limit, $offset)
        ->order_by("tanggal_rilis", "DESC")
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

    public function update($id_dokumentasi, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_dokumentasi', $id_dokumentasi)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_dokumentasi)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_dokumentasi', $id_dokumentasi)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_dokumentasi)
    {
        $this->db->where('id_dokumentasi', $id_dokumentasi)
        ->delete($this->table);
    }
    

    public function lihat($sampai, $dari, $like = ''){
 
   if($like)

    $this->db
    ->join('users', 'users.id_jrs = kejuruan.id_jrs')
    ->where($like);
 
   $query = $this->db->get('kejuruan',$sampai,$dari);
   return $query->result_array();
  }

  }