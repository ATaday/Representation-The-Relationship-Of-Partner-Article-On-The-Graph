<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index(){
		if(isset($this->session->userdata['user']['user_id'])){
			$this->load->model("dashboard_model");
			$data["authors"] = $this->dashboard_model->getAuthors();
			$this->load->view("dashboard",$data);
		}
		else{
			header("Location: ".base_url()."login");
		}
	}

	public function auto_complete($text){
		$authors = $this->db->query("SELECT * FROM authors WHERE author_name LIKE '%".urldecode($text)."%' LIMIT 10")->result_array();
		echo json_encode($authors);
	}
}