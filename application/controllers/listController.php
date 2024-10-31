<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class listController extends CI_Controller{

public function __construct(){
parent::__construct();
$this->load->database();
$this->load->model("list_model");
$this->load->model("Calculate_model");
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

public function search() {
    $search = $this->input->get("search");
    if (empty($search)) {
        $param = $this->list_model->get_all();
    } else {
        $param = $this->list_model->search($search);
    }
    echo json_encode($param);


}



public function index2(){
	$this->load->view("index2");
}

public function calculatorPage(){
	$this->load->view("task/calculator");
}


public function calculate() {
    if ($this->input->post("num1") && $this->input->post("num2")) {
        $num1 = $this->input->post("num1");
        $num2 = $this->input->post("num2");
        $operator = $this->input->post("operator");

        switch ($operator) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                $result = ($num2 != 0) ? $num1 / $num2 : "Cannot divide by zero!";
                break;
            case "pow":
                $result = pow($num1, $num2);
                break;
            case "root":
                $result = pow($num1, 1 / $num2);
                break;
            default:
                $result = "Invalid operator!";
                break;
        }

        $param = [
            "num1" => $num1,
            "operation" => $operator,
            "num2" => $num2,
            "result" => $result
        ];

        $this->Calculate_model->create($param);

        echo json_encode($param);
    }
}

public function calculations(){
		$this->load->view("task/calculations");
}

}
