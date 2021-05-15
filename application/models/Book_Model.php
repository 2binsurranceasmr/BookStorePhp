<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Book_Model extends CI_Model {

    Public function __construct() {

        parent::__construct();
    }

    // Đếm số record trong bảng
    public function get_total() {
        return $this->db->count_all("book");
    }

    // Lấy hết sách của page
    public function get_current_page_records($limit, $start,$sort=false, $property=null, $order=null) {

        // Lấy book của page, từ offset $start
        $this->db->limit($limit, $start);
        
        // Nếu có thực hiện sort
        if($sort==true){
            $this->db->order_by($property,$order);
        }
        $query = $this->db->get("book");

        // Trả về dữ liệu
        return $query->result();
    }

    // Lấy lấy sách dựa theo ID 
    public function get_by_id($id) {
        $query = $this->db->get_where("book", array("id" => $id));
        $result = $query->row();
        return $result;
    }

    // Trả về kết quả tìm kiếm dựa theo title

    public function search_by_title($title) {
        $this->db->like('title', $title);
        $query = $this->db->get('book');
        $result = $query->result();
        return $result;
    }

    // Sách này có tồn tại hay không

    public function does_have($id) {
        $query = $this->db->get_where('book', array('id' => $id));
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function update($id, $data) {
        $this->db->set($data);
        $this->db->where("id", $id);
        $this->db->update("book", $data);
    }
    
    public function insert($data){
        $this->db->insert('book',$data);
    }
    
//    public function sort_by($property,$order){
//        $this->db->order_by($property,$order);
//        $query = $this->db->get('book');
//        $result = $query->result();
//        return $result;
//    }

}
