<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class list_model extends CI_Model {

public function create($param){
  return $this->db->insert("lists",$param);
}



public function get_all(){
  $this->db->where("deleted_at", null);
  return $this->db->get("lists")->result();
}

public function getId($id){
  $query=$this->db->query("SELECT * FROM lists WHERE id=?",[$id]);
  return $query->row();
}

public function update($id,$param)
{
  $this->db->where("id",$id);
  return $this->db->update("lists",$param);
}

public function delete($id,$param){
  $this->db->where("id",$id);
  return $this->db->update("lists",$param);
}

public function search($search)
{
  $this->db->like("name",$search);
  $this->db->or_like("deadline",$search);
  return $this->db->get("lists")->result();
}

}
