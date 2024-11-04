<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Like_model extends CI_Model {
    public function toggle_like($user_id, $post_id) {
        $this->db->where(['user_id' => $user_id, 'post_id' => $post_id]);
        $like = $this->db->get('likes')->row();

        if ($like) {
            $this->db->delete('likes', ['id' => $like->id]);
            return false;
        } else {
            $this->db->insert('likes', ['user_id' => $user_id, 'post_id' => $post_id]);
            return true;
        }
    }

    public function get_like_count($post_id) {
        $this->db->where('post_id', $post_id);
        return $this->db->count_all_results('likes');
    }
}
