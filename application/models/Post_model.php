<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {
    public function save_post($param)
    {
      return $this->db->insert("posts",$param);
    }

    public function get_posts_by_user($user_id)
    {
        return $this->db->get_where("posts", ['user_id' => $user_id])->result();
    }

  }
