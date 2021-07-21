<?php
  class Model_suara_partai extends CI_Model {

    public $table = 'suara_partai';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_suara_partai($limit, $offset)
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

    public function update($id_suara_partai, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_suara_partai', $id_suara_partai)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_suara_partai)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_suara_partai', $id_suara_partai)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_suara_partai)
    {
        $this->db->where('id_suara_partai', $id_suara_partai)
        ->delete($this->table);
    }
    
    public function tambahan($where)
    {
      // Jalankan query
      $query= $this->db->select('*')
                  ->from('suara_partai')
                  ->join('suara_partai', 'suara_partai.id_suara_partai = suara_partai.id_suara_partai')
                  ->join('dapil', 'dapil.id_dapil = suara_partai.id_dapil')
                  ->where($where)
                  ->get();

      // Return hasil query
      return $query;
    }

    public function get_caleg()
    {
      // Jalankan query
      $query = $this->db->get('caleg');

      // Return hasil query
      return $query;
    }

        public function total_caleg($where)
    {
      // Jalankan query
      $query = $this->db->select('*')->select_sum('jsuara_caleg','totalc')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->where($where)
                  ->where('tahun','2019')
                  ->group_by('partai.id_partai')
                  ->order_by('no_urutpartai', "asc")
                  ->get();

      // Return hasil query
      return $query;
    }

            public function total_partai($where)
    {
      // Jalankan query
      $query = $this->db->select('*')->select_sum('jsuara_partai','totalp')
                  ->from('suara_partai')
                  ->join('partai', 'partai.id_partai = suara_partai.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_partai.id_regenc')
                  ->where($where)
                  ->where('tahun','2019')
                  ->group_by('partai.id_partai')
                  ->order_by('no_urutpartai', "asc")
                  ->get();

      // Return hasil query
      return $query;
    }

    public function GetPie(){
$query=$this->db->query("select * from suara_partai INNER JOIN partai
ON suara_partai.id_partai = partai.id_partai;");
return $query;
}
  }