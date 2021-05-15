<?php


defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cartitem_Model extends CI_Model {

    Public function __construct() {

        parent::__construct();
    }
    
    public function add($data){
        $this->db->insert('cartitem',$data);
    }
    
    // Lấy giỏ hàng của khách (status = 0, account_id = session id)
    public function get_cart($param){
        
        $this->db->select('C.id, B.image, B.title, C.quantity, B.price, C.order_date ');
        $this->db->from('cartitem as C');
        $this->db->join('book as B', 'C.book_id = B.id');
        $this->db->where($param);
        return $this->db->get()->result();
    }
    
    //Xóa 1 dòng record trong bảng cartitem
    public function delete($id){
        $this->db->delete('cartitem',array('id'=>$id));
    }
    
    // Lấy 1 record dựa trên id
    public function get_by_id($id){
        $query = $this->db->get_where('cartitem',array('id'=>$id));
        return $query->row();
    }
    
    // Có record này tồn tại hay không
    public function does_have($id){
        $query = $this->db->get_where('cartitem',array('id'=>$id));
        if(!$query->num_row() != 1 ){
            return false;
        }
        else {
            return true;
        }
    }
    
    // Thanh toán giỏ hàng
    public function set_paid($account_id, $shipping_id) {
        // Chuyển trạng thái sang đã thanh toán, cập nhật shipping_id
        $data = array(
            'status' => 1,
            'shipping_id' => $shipping_id
        );
        
        $this->db->where(array('account_id'=> $account_id,'status'=>0));
        $this->db->update('cartitem', $data);
    }
    
    // Lấy lịch sử mua hàng (status = 1, account_id = session id)
    public function get_history($param){
        
        $this->db->select(' B.image, B.title, C.quantity, C.order_date,S.status');
        $this->db->from('cartitem as C');
        $this->db->join('book as B', 'C.book_id = B.id');
        $this->db->join('shipping as S', 'S.id=C.shipping_id');
        $this->db->where(array('C.account_id'=>$param['account_id'],'C.status'=>$param['status']));
        return $this->db->get()->result();
    }
    
    // Lịch sử mua sắm
    public function get_shipping_cartitem($shipping_id){
        $this->db->select(' B.image, B.title, C.quantity, C.order_date,S.status');
        $this->db->from('cartitem as C');
        $this->db->join('book as B', 'C.book_id = B.id');
        $this->db->join('shipping as S', 'S.id=C.shipping_id');
        $this->db->where(array('shipping_id'=>$shipping_id));
        return $this->db->get()->result();
        
    }
    
    public function get_purchased_statistic(){
        $query='SELECT b.image, b.title, SUM(quantity) AS total '
                . 'FROM cartitem AS c JOIN book as b '
                . 'WHERE c.book_id = b.id '
                . 'GROUP BY b.title '
                . 'ORDER BY total DESC ';
        $result=$this->db->query($query);
        return $result->result();
    }
}
