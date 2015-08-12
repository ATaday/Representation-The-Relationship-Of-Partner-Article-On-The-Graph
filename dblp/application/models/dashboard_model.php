<?php 

class Dashboard_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getAuthors(){
        return $this->db->query("SELECT * FROM authors LIMIT 10")->result_array();
    }
}

?>