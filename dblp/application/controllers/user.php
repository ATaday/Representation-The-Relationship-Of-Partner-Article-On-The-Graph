<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function index(){
		if(!isset($this->session->userdata['user']['user_id'])){
			header("Location: login");
		}		
		else{
			$this->load->view("user_page");
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		header("Location: ".base_url()."login");
	}

	public function sign_up(){
		if(isset($this->session->userdata['user']['user_id'])){
			header("Location: ".base_url());
		}		
		else{
			if($this->input->post()){
				$this->load->model("user_model");
				$user = $this->user_model->get_user_with_email($this->input->post('email'));
				if(empty($user)){
					$added_user = $this->user_model->signup_user($this->input->post());
					$this->session->set_userdata('user',$added_user);
					header("Location: ".base_url());
				}
				else{
					$this->session->set_flashdata('error', 'There is a user with this email.');
					header("Location: ".base_url()."user/sign_up");
				}
			}
			else{
				$this->load->view("signup_page");
			}
		}
	}

	public function my_graphs(){
		if(isset($this->session->userdata['user']['user_id'])){
			$this->load->model("user_model");
			$graphs = $this->user_model->get_saved_graphs();
			$data['saved_graphs'] = array();
			$k = 0;
			foreach ($graphs as $graph) {
				
				$data['saved_graphs'][$k]['authors'] = unserialize($graph['data']);
				
				
				foreach ($data['saved_graphs'][$k]['authors'] as $author) {
					$df = $this->db->query("SELECT author_name FROM authors WHERE author_id='".$author."' LIMIT 1")->row(0,"array");
					$data['saved_graphs'][$k]["authors_name"][] = $df['author_name'];
				}

				$data['saved_graphs'][$k]['created'] = $graph['created'];
				$data['saved_graphs'][$k++]['id'] = $graph['data_id'];
			}
			$this->load->view("my_graphs",$data);
		}
		else {
			header("Location: ".base_url());
		}	
	}

	public function delete_graph($id){
		if(isset($this->session->userdata['user']['user_id'])){
			$this->load->model("user_model");
			$this->user_model->delete_graph($id);
			header("Location: ".base_url()."user/my_graphs");
		}
		else{
			header("Location: ".base_url());
		}
	}

	public function draw_graph($id){
		if(isset($this->session->userdata['user']['user_id'])){
			$this->load->model("user_model");
			$graph = $this->user_model->get_graph($id);

			if(empty($graph)){
				header("Location: ".base_url()."user/my_graphs");
			}

			$graph["authors"] = unserialize($graph['data']);
			$authors = $graph['authors'];
			$this->load->view("simple_html_dom_parser");

			$data['db_add'] = serialize($authors);
			$array_xc = array();
			$ji = 0;

		foreach ($authors as $author) {

			$yazar1_exp = $this->db->query("SELECT * FROM authors WHERE author_id=".$this->db->escape($author))->row(0,"array");
			$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
			$context = stream_context_create($opts);
			$html = file_get_html($yazar1_exp['author_link'],false,$context);
			$i = "1";

			foreach($html->find('ul.publ-list li.article div.data') as $htmlin) {
	   			foreach ($htmlin->find("span[itemprop=author] span[itemprop=name]") as $authors) {
	   				$data["authors_list"][] = $authors->plaintext;
	   				$data["authors_nodes"][] = $authors->plaintext;
	   			}

	   			foreach ($htmlin->find("span.title") as $book) {
	   				$data["authors_list_book"][] = $book->plaintext;
	   				$data["authors_books"][] = $book->plaintext;
	   			}

	   			$array_xc[$ji]['nodes'] = $data['authors_nodes'];
				$array_xc[$ji++]['books'] = $data['authors_books'];

			unset($data["authors_nodes"]);
			unset($data["authors_books"]);
			}
			
		}
		
		$data['authors_list'] = array_unique($data['authors_list']);
		$data["encoded_authors_list"] = array();

		foreach ($data['authors_list'] as $a55) {
			$data['encoded_authors_list'][] = urlencode($a55);
		}

		$data['array_xc'] = $array_xc;	
		$for_level_up = array();

		foreach ($data['authors_list'] as $authors_names_for_level) {
			$exploded_names = explode(' ', $authors_names_for_level);
			$sql = "SELECT * FROM authors WHERE";

			foreach ($exploded_names as $exploded_name) {
				if($exploded_name!=""){
					$sql.=" author_name LIKE '%".$exploded_name."%' AND ";
				}
			}

			$sql.= "1=1 LIMIT 1";
			$linked_author = $this->db->query($sql)->row(0,"array");
			
			if(isset($linked_author['author_id'])){
				$for_level_up[] = $linked_author['author_id'];
			}		
		}

			$data['for_level_up'] = $for_level_up;
			$temp_array = array();

		for ($i=0; $i < count($data['array_xc']); $i++) { 
			if(in_array($data['array_xc'][$i]['books'][0], $temp_array)){
				unset($data['array_xc'][$i]);
			}
			else{
				$temp_array[] = $data['array_xc'][$i]['books'][0];
			}
		}

		$data['array_xc'] = array_values($data['array_xc']);	
		$this->load->view("graph",$data);

		}
		else{
			header("Location: ".base_url());
		}
	}

	public function save_graph(){
		echo $this->db->query("INSERT INTO data SET user_id='".$this->session->userdata['user']['user_id']."', data='".$this->input->post('add_db')."', created=NOW()");
		
	}

}