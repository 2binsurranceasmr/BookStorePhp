<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cartitem_Controller extends CI_Controller {

    public function index() {

        $this->load->view('Index');
    }

    // Thêm 1 sản phẩm vào giỏ, do khách đặt vào
    public function add($id) {


        // Kiểm tra xem clinet có đăng nhập không
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }
        // Validate input
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|is_natural_no_zero');
        
        if ($this->form_validation->run() == FALSE) {
            // Tải lại trang xem sách
            redirect(base_url().'Book_Controller/books');
        } else {

            // Nếu có thì thêm vào giỏ
            if ($this->input->post('add')) {

                $data = array(
                    'account_id' => $this->session->userdata('account')->id,
                    'quantity' => $this->input->post('quantity'),
                    'book_id' => $id,
                    'status' => 0,
                    'order_date' => date("Y/m/d")
                );

                $this->Cartitem_Model->add($data);
            }

            // Sau đó trở về xem sách
            redirect(base_url() . 'Book_Controller/books');
        }
    }


    // Giỏ hàng, gồm các sản phẩm chưa thanh toán
    public function viewShoppingCart() {

        // kiểm tra client có đăng nhập không
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }

        // id của account đang login
        $param = array(
            'account_id' => $this->session->userdata('account')->id,
            'status' => 0
        );
        
        $data['account'] = $this->Account_Model->get_by_id($param['account_id']);
        
        // Lấy danh sách cartitem của khách hàng có status = 0
        $data['cartitems'] = $this->Cartitem_Model->get_cart($param);
        // Tính tổng giá
        $data['price'] = $this->total_cart_price($data['cartitems']);
        $data['total_price'] = $data['price'] + $this->get_ship_price();
        $data['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id);
        $this->load->view('Cart', $data);
    }

    // Tính tổng tiền của giỏ hàng
    public function total_cart_price($cartitems) {
        $total_price = 0;
        foreach ($cartitems as $cart) {
            $total_price += ($cart->quantity) * ($cart->price);
        }
        return $total_price;
    }

    // Giá ship, mặc định 0
    public function get_ship_price() {
        return 0;
    }

    // Xóa 1 vật phẩm trong giỏ hàng của account hiện có trong session
    public function delete($id) {

        // Kiểm tra xem client có thực hiện lệnh xóa mà không đăng nhập không
        if ($this->session->userdata('account') == null) {
            show_404();
        }

        // Lấy id của cartitem cần xóa

        $cartitem = $this->Cartitem_Model->get_by_id($id);

        // Kiểm tra cartitem có đang chờ không, và có thuộc user đang đăng nhập không
        if ($cartitem->account_id == $this->session->userdata('account')->id && $cartitem->status == 0) {
            // Nếu đúng thì xóa và refresh
            $this->Cartitem_Model->delete($id);
            redirect(base_url() . 'Cartitem_Controller/viewShoppingCart');
        } else {
            // Nếu không thì chỉ refresh
            redirect(base_url() . 'Cartitem_Controller/viewShoppingCart');
        }
    }

    // Lịch sử mua hàng
    public function viewHistory() {
        // phải đăng nhập mới xem được lịch sử mua
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }

        $account_id = $this->session->userdata('account')->id;
        $status = 1;
        $params['condititon'] = array('account_id' => $account_id, 'status' => $status);

        // Lấy kết quả đổ vào data
        $param['cartitems'] = $this->Cartitem_Model->get_history($params['condititon']);
        $param['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id);
        $this->load->view('History', $param);
    }

}
