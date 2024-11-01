<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  public function get_all()
  {
    $query=$this->db->get("users");
    return $users=$query->result();
  }

  public function get_user($email,$password)
  {
    $this->db->where('email', $email);
    $this->db->where('password', $password);
    $query = $this->db->get('users');

    if (!$query->num_rows()) {
      return null;
    }

    $user = $query->row();
    return $user;
  }
}
