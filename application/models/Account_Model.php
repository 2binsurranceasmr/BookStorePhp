<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Account_Model extends CI_Model{
    Public function __construct() {

        parent::__construct();
    }
    
    // Lấy tất cả record trong bảng account của database
    public function getAll() {
        $result = $this->db->get('account');
        return $result->result();
    }
    
    public function isExist($username){
        
        $query = $this->db->get_where('account',array('user_name'=>$username));
        
        $rows = $query ->num_rows();
        
        if($rows){
            return true;
        }
        else return false;
    }
    

    
    public function getByUsername($username){
        $query = $this->db->get_where('account',array('user_name'=>$username));
        $result = $query->row();
        return $result;
    }
    
    //return if $data exist
    
    public function confirmAccount($data){
        $account = $this->getByUsername($data['user_name']);
        if(md5($data['pwd']) == $account->pwd){
            return true;
        }
        else return false;
    }
    
    public function create($data){
        $this->db->insert('account',$data);
    }
    
    public function get_by_id($id){
        $query = $this->db->get_where('account',array('id'=>$id));
        $result = $query -> row();
        return $result;
    }
    
    public function update($id, $data){
        $this->db->set($data);
        $this->db->where("id", $id);
        $this->db->update("account", $data);
    }
    
    public function update_password($password,$username){
        $this->db->set(array('pwd'=>$password));
        $this->db->where("user_name",$username);
        $this->db->update('account',array('pwd'=>$password));
    }
    
    public function get_purchased_statistic(){
        $query = 'select a.id, a.full_name, sum(c.quantity * b.price) as total '
                . 'from shipping as sh join cartitem as c join book as b join account as a '
                . 'where sh.id = c.shipping_id and b.id=c.book_id and a.id = c.account_id '
                . 'GROUP by a.id '
                . 'order by total desc ';
        $result = $this->db->query($query);
        return $result->result();
    }
}
