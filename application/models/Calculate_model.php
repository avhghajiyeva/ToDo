<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculate_model extends CI_Model {

public function create($param){
    return $this->db->insert("calculations",$param);
  }

  public function get_all(){
    $query= $this->db->get("calculations");
    return $query->result();
  }
}
