<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', -1);

class Welcome extends CI_Controller {
	public function index(){

		$this->load->view("simple_html_dom_parser");
		$authors_idsp = $this->input->post("id");
		$data['db_add'] = serialize($authors_idsp);

		if($this->input->post("level_down")&&$this->input->post("level_down")!=""){
			$data['level_down'] = "1";
			$data['level_down_ids_authors'] = unserialize($this->input->post("level_down"));
		}

		$array_xc = array();
		$ji = 0;
		
		foreach ($authors_idsp as $author) {
			
			$yazar1_exp = $this->db->query("SELECT * FROM authors WHERE author_id=".$this->db->escape($author))->row(0,"array");
			$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
			$context = stream_context_create($opts);
			$html = file_get_html($yazar1_exp['author_link'],false,$context);
			$i = "1";

			if($html && is_object($html) && isset($html->nodes)){
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
			
		}

		if(!isset($data['authors_list'])){
			$this->session->set_flashdata('error', 'No article for this authors.');
			header("Location: ".base_url());
		}

		$data['authors_list'] = array_unique($data['authors_list']);
		$data["encoded_authors_list"] = array();

		foreach ($data['authors_list'] as $a55) {
			$data['encoded_authors_list'][] = urlencode($a55);	
		}

		$for_level_up = array();

		foreach ($data['authors_list'] as $authors_names_for_level) {

			$exploded_names = explode(' ', $authors_names_for_level);
			$sql = "SELECT * FROM authors WHERE";

			foreach ($exploded_names as $exploded_name) {
				if($exploded_name!=""){
					$sql.=" author_name LIKE '%".str_replace("'", "\'", $exploded_name)."%' AND ";
				}
			}

			$sql.= "1=1 LIMIT 1";

			$linked_author = $this->db->query($sql)->row(0,"array");

			if(isset($linked_author['author_id'])){
				$for_level_up[] = $linked_author['author_id'];
			}
		}

		$data['for_level_up'] = $for_level_up;
		$data['array_xc'] = $array_xc;		

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

		for ($i=0; $i < count($data['array_xc']); $i++) { 
			$data['array_xc'][$i]['books'][0] = str_replace("'", "\'", $data['array_xc'][$i]['books'][0]);
			
		}

		$this->load->view("graph",$data);
	}

	public function startsWith($haystack, $needle) {
    	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	public function fetch_data2(){

		$this->load->view("simple_html_dom_parser");
		$it = 0;
		
		for ($i=1524716; $i <1590976 ; $i = $i+300) { 

			$html = file_get_html('http://dblp.uni-trier.de/pers?pos='.$i);

			foreach($html->find('div#browse-person-output div.columns a') as $element) {
       			$name = $element->innertext;
       			$link = $element->href;
       			$this->db->query("INSERT INTO authors SET author_name=".$this->db->escape($name).", author_link=".$this->db->escape($link).", author_date_added=NOW()");
			}
			echo $it++."<br>";
		}
	}
}