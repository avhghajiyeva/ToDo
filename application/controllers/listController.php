<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class listController extends CI_Controller{

public function __construct(){
parent::__construct();
$this->load->database();
$this->load->model("list_model");
$this->load->library("session");
$this->load->helper('url');
}


public function index(){
	$param=$this->list_model->get_all();
	$this->load->view("task/index", ['param' => $param]);
}

public function show(){
	$this->load->view("task/create");
}

 public function create(){
	 $token = bin2hex(random_bytes(16));
	 //$token = uniqid();
	 if($this->input->post()){
		 $param=[
			 "name"=>$this->input->post("name"),
			 "description"=>$this->input->post("description"),
			 "deadline"=>$this->input->post("deadline"),
			 "token"=> $token
		 ];
		 $this->list_model->create($param);
		 redirect("index");
	 }
 }

public function edit($id){
	$list=$this->list_model->getId($id);

	if ($list) {
				    $this->load->view("task/edit", ['list' => $list]);
    } else {

        show_404();
    }
	}

	public function update($id){
	if($this->input->post()){
		$param=[
			"name"=>$this->input->post("name"),
			"description"=>$this->input->post("description"),
			"deadline"=>$this->input->post("deadline")
		];
			$this->list_model->update($id, $param);
			redirect("index");
	}
}

public function delete($id)
{
	$param = [
	    "deleted_at" => date('Y-m-d H:i:s')
	];
	$this->list_model->delete($id,$param);
	redirect("index");
}

public function search(){
	$search=$this->input->get("search");
	$param=$this->list_model->search($search);
	// $this->load->view("task/index",['param' => $param]);
	echo json_encode($param);
}

}
