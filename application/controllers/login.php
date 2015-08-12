<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index(){
		if(isset($this->session->userdata['user']['user_id'])){
			header("Location: user");
		}		
		else{
			if($this->input->post()){
				$this->load->model("user_model");
				$user = $this->user_model->get_user($this->input->post());

				if(empty($user)){
					$this->session->set_flashdata('error', 'No user with this information.');
					header("Location: ".base_url()."login");
				}
				else{
					$this->session->set_userdata('user',$user);
					header("Location: ".base_url());
				}
			}
			else{
				$this->load->view("login_page");
			}
		}
	}
}