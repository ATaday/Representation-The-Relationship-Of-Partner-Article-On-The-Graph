<?php 

class User_model extends CI_Model {
  
    function __construct()
    {
        parent::__construct();
    }

    function get_user($data){
       return $this->db->query("SELECT * FROM users WHERE user_email='".$data['email']."' && user_password='".$data['password']."' LIMIT 1")->row(0,"array");
    }

    function get_user_with_email($email){
      return $this->db->query("SELECT * FROM users WHERE user_email='".$email."' LIMIT 1")->row(0,"array");
    }

    function signup_user($data){
      $this->db->query("INSERT INTO users SET user_email='".$data['email']."', user_password='".$data['password']."', user_name='".$data['name']."', user_surname='".$data['surname']."', user_created=NOW()");
    
      return $this->db->query("SELECT * FROM users WHERE user_id='".$this->db->insert_id()."' LIMIT 1")->row(0,"array");
    }

    function get_saved_graphs(){
      return $this->db->query("SELECT * FROM data WHERE user_id='".$this->session->userdata['user']['user_id']."'")->result_array();
    }

    function delete_graph($id){
      $this->db->query("DELETE FROM data WHERE data_id='".$id."' LIMIT 1");
    }

    function get_graph($id){
      return $this->db->query("SELECT * FROM data WHERE user_id='".$this->session->userdata['user']['user_id']."' AND data_id='".$id."' LIMIT 1")->row(0,"array");
    }

}

?>