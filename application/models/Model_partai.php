<?php
  class Model_partai extends CI_Model {

    public $table = 'partai';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_partai($limit, $offset)
    {
      // Jalankan query
      $query = $this->db
        ->limit($limit, $offset)
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

    public function update($id_partai, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_partai', $id_partai)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_partai)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_partai', $id_partai)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_partai)
    {
        $this->db->where('id_partai', $id_partai)
        ->delete($this->table);
    }
    
    public function tambahan($where)
    {
      // Jalankan query
      $query= $this->db->select('*')
                  ->from('partai')
                  ->join('partai', 'partai.id_partai = partai.id_partai')
                  ->join('dapil', 'dapil.id_dapil = partai.id_dapil')
                  ->where($where)
                  ->get();

      // Return hasil query
      return $query;
    }

  }