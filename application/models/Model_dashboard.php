<?php
class Model_dashboard extends CI_Model{

    public function hitungtot()
{   
    $query = $this->db->get('skripsi_komentar');
    if($query->num_rows()>0)
    {
      return $query->num_rows();
    }
    else
    {
      return 0;
    }
}

public function hitungpos()
{   
    $query = $this->db->select('*')
    ->from('skripsi_komentar')
    ->where(array('sentimen' => 1))
    ->get();;
    if($query->num_rows()>0)
    {
      return $query->num_rows();
    }
    else
    {
      return 0;
    }
}

public function hitungneg()
{   
    $query = $this->db->select('*')
    ->from('skripsi_komentar')
    ->where(array('sentimen' => 0))
    ->get();
    if($query->num_rows()>0)
    {
      return $query->num_rows();
    }
    else
    {
      return 0;
    }
}
 
}