<?php


defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Shipping_Model extends CI_Model {

    Public function __construct() {

        parent::__construct();
    }
    // Thêm 1 record (phiếu giao hàng)
    public function add($data){
        $this->db->insert('shipping',$data);
    }
    
    // Lấy ra phiếu giao hàng mới nhất
    public function get_last(){
        $this->db->select('*');
        $this->db->from('shipping');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        return $query->last_row();
    }
    // Lấy tất cả đơn đặt hàng chưa được giao
    public function get_all_unshipped(){
        $query = $this->db->get_where('shipping',array('status'=>0));
        $result = $query->result();
        return $result;
    }
    
    public function ship($id){
        $this->db->set(array('status'=>1));
        $this->db->where("id", $id);
        $this->db->update("shipping", array('status'=>1));
        
    }
    
    public function does_have($id){
        $query = $this->db->get_where('shipping',array('id'=>$id));
        if($query->num_rows()<1){
            return false;
        }
        else 
            return true;
    }
}