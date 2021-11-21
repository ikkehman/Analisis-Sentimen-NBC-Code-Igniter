<?php
  class Model_normalisasi extends CI_Model {

    public $table = 'normalisasi';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_normalisasi($limit, $offset)
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

    public function update($id_normal, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_normal', $id_normal)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_normal)
    {
      // Jalankan query
      $query = $this->db
        ->where('id_normal', $id_normal)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_normal)
    {
        $this->db->where('id_normal', $id_normal)
        ->delete($this->table);
    }

    function get_all() {
      $this->datatables->select('id_normal,normal,upnormal');
      $this->datatables->from('normalisasi');
      $this->datatables->add_column('view', '<a href="normalisasi/edit/$1" class="edit_record btn btn-info" data-code="$1">Edit</a>  <a href="javascript:void(0);" class="delete_record btn btn-danger" data-toggle="modal" data-target="#modal-konfirmasi" data-code="$1">Delete</a>','id_normal,normalisasi');
      $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','id_normal');
      return $this->datatables->generate();
  }

  }