<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Shipping_Controller extends CI_Controller {

    public function index() {

        $this->load->view('Index');
    }

    // Khi khách hàng thanh toán, thêm 1 phiếu giao hàng
    public function add() {
        // ngăn chặn user truy cập = link trực tiếp
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }
        // kiểm tra form
        $this->form_validation->set_rules('card_owner', 'Card Owner', 'required');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required|is_natural');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('number_phone', 'Phone Number', 'required|is_natural');
        
        // Nếu có lỗi, tải lại trang
        if ($this->form_validation->run() == FALSE) {
            // Tải lại trang
            redirect(base_url().'Cartitem_Controller/viewShoppingCart');
        } else {

            // Nếu giỏ hàng trống
            $param = array('status' => 0, 'account_id' => $this->session->userdata('account')->id);
            if ($this->Cartitem_Model->get_cart($param) == null) {
                // thì refresh
                redirect(base_url() . 'Cartitem_Controller/viewShoppingCart', 'refresh');
            } else {
                // Nếu không trống thì tiến hành thêm phiếu giao hàng
                if ($this->input->post('pay')) {
                    // Lấy dữ liệu từ form
                    $data['shipping_info'] = array(
                        'card_owner' => $this->input->post('card_owner', true),
                        'card_number' => $this->input->post('card_number', true),
                        'address' => $this->input->post('address', true),
                        'city' => $this->input->post('city', true),
                        'number_phone' => $this->input->post('number_phone', true),
                        'account_id' => $this->session->userdata('account')->id,
                    );

                    // Thêm phiếu vào database
                    $this->Shipping_Model->add($data['shipping_info']);

                    // Lấy id của phiếu vừa tạo gán cho ship_id của sản phẩm trong giỏ và xác nhận là đã trả tiền
                    $data['shipping_id'] = $this->Shipping_Model->get_last()->id;
                    $this->Cartitem_Model->set_paid($this->session->userdata('account')->id, $data['shipping_id']);

                    // Chuyển hướng trang cảm ơn

                    $this->load->view('AfterPurchasing', $data);
                }
            }
        }
    }

    // Xem các đơn đặt hàng hiện có
    public function ships(){
        $data['ships'] = $this->Shipping_Model->get_all_unshipped();
        $data['role'] = 'ADMIN';
        $this->load->view('Ships',$data);
    }
    
    // Thêm phiếu giao hàng
    public function ship($id){
        
        if($this->Shipping_Model->does_have($id)){
            $this->Shipping_Model->ship($id);
        }
        redirect(base_url().'Shipping_Controller/ships');
    }
    
    // Xem các sản phẩm thuộc 1 đơn đặt hàng nào đó
    public function viewShippingCartitem($shipping_id){
        $data['cartitems'] = $this->Cartitem_Model->get_shipping_cartitem($shipping_id);
        $data['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id );
        $this->load->view('ShipDetails',$data);
    }

}
