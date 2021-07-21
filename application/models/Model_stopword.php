<?php
  class Model_stopword extends CI_Model {

    public $table = 'stopword_list';

    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

      // Return hasil query
      return $query;
    }

    public function get_stopword($limit, $offset)
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

    public function update($id_stopword, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('id', $id_stopword)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($id_stopword)
    {
      // Jalankan query
      $query = $this->db
        ->where('id', $id_stopword)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

    public function delete_by_id($id_stopword)
    {
        $this->db->where('id', $id_stopword)
        ->delete($this->table);
    }

    function get_all() {
      $this->datatables->select('id,stopword');
      $this->datatables->from('stopword_list');
      $this->datatables->add_column('view', '<a href="stopword/edit/$1" class="edit_record btn btn-info" data-code="$1">Edit</a>  <a href="javascript:void(0);" class="delete_record btn btn-danger" data-toggle="modal" data-target="#modal-konfirmasi" data-code="$1">Delete</a>','id,stopword');
      $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','username');
      return $this->datatables->generate();
  }

  }