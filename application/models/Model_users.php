<?php
  class Model_users extends CI_Model {

    public $table = 'users';


    public function cekAkun($username, $password)
    {
      // Get data user yang mempunyai username == $username dan active == 2
			//$this->db
      //     ->join('regencies','regencies.id_regen=users.wilayah')
       //    ->where('username', $username);
			//$this->db->where('active', '1');
			
      // Jalankan query
      $query = $this->db->get($this->table)->row();
      
      // Jika query gagal atau tidak menemukan username yang sesuai 
      // maka return false
			if (!$query) return false;
			
      // Ambil data password dari database
      $hash = $query->password;
      
      // Jika $hash tidak sama dengan $password maka return false
      if (!password_verify($password, $hash)) return false;
      
      // Jika username dan password benar maka return data user
      return $query;        
    }

    public function cekPasswordLama($username, $password)
    {
      // Get data user yang mempunyai id == $id dan active == 1
			$this->db->where('username', $username);
			
      // Jalankan query
      $query = $this->db->get($this->table)->row();
      
      // Jika query gagal atau tidak menemukan data yang sesuai 
      // maka return false
			if (!$query) return false;
			
      // Ambil data password dari database
      $hash = $query->password;
      
      // Jika $hash tidak sama dengan $password maka return false
      if (!password_verify($password, $hash)) return false;
      
      // Jika username dan password benar maka return data user
      return $query;        
    }


    public function get()
    {
      // Jalankan query
      $query = $this->db->get($this->table);

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

    public function update($username, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('username', $username)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }

    public function delete($username)
    {
      // Jalankan query
      $query = $this->db
        ->where('username', $username)
        ->delete($this->table);
      
      // Return hasil query
      return $query;
    }

        public function delete_by_id($username)
    {
        $this->db->where('username', $username)
        ->delete($this->table);
    }

    public function get_offset($limit, $offset)
    {
      // Jalankan query
      $query = $this->db
        ->limit($limit, $offset)
        ->get($this->table);

      // Return hasil query
      return $query;
    }


  public function getByusername($username){
  $this->db->where('username',$username);
  $result = $this->db->get('users');
  return $result;
}
 
public function simpanToken($data){
  $this->db->insert('lupa', $data);
  return $this->db->affected_rows();
}
 
public function cekToken($token){
  $this->db->where('token',$token);
  $result = $this->db->get('lupa');
  return $result;
}

public function ubah_password($username, $data)
    {
      // Jalankan query
      $query = $this->db
        ->where('username', $username)
        ->update($this->table, $data);
      
      // Return hasil query
      return $query;
    }
    
    function get_all() {
      $this->datatables->select('username,nama,level');
      $this->datatables->from('users');
      $this->datatables->add_column('view', '<a href="users/edit/$1" class="edit_record btn btn-info" data-code="$1">Edit</a>  <a href="javascript:void(0);" class="delete_record btn btn-danger" data-toggle="modal" data-target="#modal-konfirmasi" data-code="$1">Delete</a>','username,nama,level');
      $this->datatables->add_column('cek', '<input type="checkbox" class="data-check" value="$1">','username');
      return $this->datatables->generate();
  }
    
  }