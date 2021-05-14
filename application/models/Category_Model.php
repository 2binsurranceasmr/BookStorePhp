<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Category_Model extends CI_Model{
    Public function __construct() {

        parent::__construct();
    }
    
    // Lấy thể loại dựa trên id
    public function get_by_id($id) {
        $query = $this->db->get_where('category',array('id'=>$id));
        $result = $query->row();
        return $result;
    }
    
    // Lấy tất cả thể loại
    public function get_all() {
        $result = $this->db->get('category');
        return $result->result();
    }
}