<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class listController extends CI_Controller{

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

public function loginPage()
{

    if ($this->session->userdata('user_id')) {
        redirect('show');
    }
    $error = $this->session->flashdata('login_error');
    $this->load->view("login");
}

public function login()
{
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $user = $this->User_model->get_user($email, $password);

    if ($user) {
        $this->session->set_userdata('user_id', $user->id);
        redirect("show");
    } else {
        $this->session->set_flashdata('login_error', 'Email or password is incorrect.');
        redirect("login-page");
    }
}

public function show(){
	if (!$this->session->userdata('user_id')) {
			redirect('login-page');
	}
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


public function index(){
	if (!$this->session->userdata('user_id')) {
			redirect('login-page');
	}
	$param=$this->list_model->get_all();
	$this->load->view("task/index", ['param' => $param]);
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


public function logout()
{
    $this->session->unset_userdata('user_id');
    $this->session->sess_destroy();
    redirect('login-page');
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

	public function all(){
	$data["calculations"]=$this->Calculate_model->get_all();
		echo json_encode($data["calculations"]);
	}
	public function communityPage()
	    {
	        if (!$this->session->userdata('user_id')) {
	            redirect('login-page');
	        }

	        // $this->load->view("task/community");
	    }

	    public function community() {
	        $user_id = $this->session->userdata('user_id');
	        if (!$user_id) {
	            echo json_encode(['error' => 'User not logged in']);
	            return;
	        }

	        $data["posts"] = $this->Post_model->get_posts();
	        echo json_encode($data["posts"]);
	    }

	    public function submit_post() {
	        $title = $this->input->post('title');
	        $description = $this->input->post('description');

	        if ($title && $description) {
	            $data = [
	                'title' => $title,
	                'description' => $description,
	                'created_at' => date('Y-m-d H:i:s')
	            ];
	            $this->Post_model->create_post($data);

	            $posts = $this->Post_model->get_posts();
	            echo json_encode($posts);
	        } else {
	            echo json_encode(['error' => 'Title and description are required']);
	        }
	    }
}
