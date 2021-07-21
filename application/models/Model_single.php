<?php
  class Model_single extends CI_Model {

    public $table = 'skripsi_komentar';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_single($limit, $offset)
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

    public function update($id_single, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('no', $id_single)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_single)
    {
      // Jalankan query
      $query = $this->db
        ->where('no', $id_single)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_single)
    {
        $this->db->where('no', $id_single)
        ->delete($this->table);
    }

    function get_all() {
      $this->datatables->select('no,komentar,stem,sentimen');
      $this->datatables->from('skripsi_komentar');
      $this->datatables->add_column('view', '<a href="single/edit/$1" class="edit_record btn btn-info" data-code="$1">Edit</a>  <a href="javascript:void(0);" class="delete_record btn btn-danger" data-toggle="modal" data-target="#modal-konfirmasi" data-code="$1">Delete</a>','no,komentar,stem,sentimen');
      $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','username');
      return $this->datatables->generate();
  }

  }