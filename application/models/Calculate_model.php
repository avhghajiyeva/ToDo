<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculate_model extends CI_Model {

public function create($param){
    return $this->db->insert("calculations",$param);
  }
}
