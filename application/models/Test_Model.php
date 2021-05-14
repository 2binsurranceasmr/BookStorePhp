<?php

Class Test_Model extends CI_Model {

    Public function __construct() {

        parent::__construct();
    }
    
    public function testGetAllAccount(){
        
        $query = $this->db->get('account')->result();
        return $query;
    }

}

?>