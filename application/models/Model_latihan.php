<?php
  class Model_latihan extends CI_Model {

    public $table = 'komentar';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_latihan($limit, $offset)
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

    public function update($id_latihan, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('no', $id_latihan)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_latihan)
    {
      // Jalankan query
      $query = $this->db
        ->where('no', $id_latihan)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_latihan)
    {
        $this->db->where('no', $id_latihan)
        ->delete($this->table);
    }

    function get_all() {
      $this->datatables->select('no,komentar,stem,sentimen');
      $this->datatables->from('komentar');
      $this->datatables->add_column('view', '<a href="latihan/edit/$1" class="edit_record btn btn-info" data-code="$1">Edit</a>  <a href="javascript:void(0);" class="delete_record btn btn-danger" data-toggle="modal" data-target="#modal-konfirmasi" data-code="$1">Delete</a>','no,komentar,stem,sentimen');
      $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','no');
      return $this->datatables->generate();
  }

  }