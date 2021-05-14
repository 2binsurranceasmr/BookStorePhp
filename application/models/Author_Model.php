<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Author_Model extends CI_Model{
    Public function __construct() {

        parent::__construct();
    }
    
    // Lấy tác giả dựa trên id
    public function get_by_id($id) {
        $query = $this->db->get_where('author',array('id'=>$id));
        $result = $query->row();
        return $result;
    }
    
    // Lấy hết danh sách tác giả
    public function get_all() {
        $result = $this->db->get('author');
        return $result->result();
    }
}