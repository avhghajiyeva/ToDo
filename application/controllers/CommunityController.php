<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommunityController extends CI_Controller{

      public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model("list_model");
      $this->load->model("Calculate_model");
      $this->load->model("User_model");
      $this->load->model("Post_model");
      $this->load->library("session");
      $this->load->helper('url');
      }

      public function toggle_like() {
    $user_id = $this->session->userdata('user_id');
    $post_id = $this->input->post('post_id');

    if (!$user_id || !$post_id) {
        echo json_encode(['error' => 'Invalid request']);
        return;
    }

    $this->load->model('Like_model');
    $liked = $this->Like_model->toggle_like($user_id, $post_id);

    echo json_encode(['liked' => $liked]);
}

}
