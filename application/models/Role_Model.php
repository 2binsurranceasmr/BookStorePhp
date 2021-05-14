<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Role_Model extends CI_Model{
    Public function __construct() {

        parent::__construct();
    }
    public function getId($name){
        $query = $this->db->get_where('role',array(
            'name'=>$name
        ));
        return $query->row()->id;
        
    }
    public function getName($id){
        $query = $this->db->get_where('role',array(
            'id'=>$id
        ));
        return $query->row()->name;
    }
}
