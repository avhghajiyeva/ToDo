<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {
  public function create_post($param) {
        return $this->db->insert("posts", $param);
    }

    public function get_posts() {
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('posts')->result();
    }
  }
