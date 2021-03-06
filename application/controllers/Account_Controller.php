<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Account_Controller extends CI_Controller {

    public function index() {

        $this->load->view('Index');
    }

    public function login() {

        $this->load->view('Login');
    }

    public function logout() {
        // xóa user khỏi session
        $this->session->sess_destroy();;
        $this->load->view('Index');
    }

    private function createSessionLogin($account) {

        // Lưu đối tượng account vào session có tên là account
        $this->session->set_userdata('account', $account);
    }

    public function confirmLogin() {
        // ngăn truy cập không mong muốn
        if (!$this->input->post('login')) {
            show_404();
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[36]');
        $this->form_validation->set_rules('pwd', 'Pasword', 'trim|required|min_length[3]|max_length[36]');
        
        if ($this->form_validation->run() == FALSE) {
            // Tải lại form + thông tin lỗi
            $this->load->view('Login',array('error'=> validation_errors()));
        } else {

            // Lấy input từ form đăng nhập
            $user_name = $this->input->post('username', true);
            $pwd = $this->input->post('pwd', true);
            $data = array('user_name' => $user_name, 'pwd' => $pwd);
            
            // Kiểm tra đăng nhập có hợp lệ không
            if ($this->Account_Model->isExist($user_name)) {
                // Nếu hợp lệ
                if ($this->Account_Model->confirmAccount($data)) {

                    // Tạo session cho tài khoản đăng nhập
                    $account = $this->Account_Model->getByUsername($data['user_name']);
                    $this->createSessionLogin($account);


                    // Nếu tài khoản là user thường
                    if ($this->Role_Model->getName($account->role_id) == 'USER') {
                        // Tải trang Books
                        redirect('/Book_Controller/books');
                    }

                    // Nếu tài khoản là admin
                    if ($this->Role_Model->getName($account->role_id) == 'ADMIN') {
                        // Tải trang BooksAdmin
                        redirect('/Book_Controller/booksAdmin');
                    }
                } else {
                    $error['error'] = 'Sai mật khẩu';
                    $this->load->view('Login', $error);
                }
            } else {
                $error['error'] = 'Tài khoản không tồn tại';
                $this->load->view('Login', $error);
            }
        }
    }

    public function register($error = '') {

        $this->load->view('Register');
    }

    public function signup() {

        $info = array();
        $this->form_validation->set_rules('user_name', 'user_name', 'trim|required|min_length[3]|max_length[36]');
        $this->form_validation->set_rules('pwd', 'Pasword', 'trim|required|min_length[3]|max_length[36]');
        $this->form_validation->set_rules('confirm_pwd', 'Password Confirmation', 'trim|required|matches[pwd]');
        // Nếu form chứa dữ liệu lỗi
        if ($this->form_validation->run() == FALSE) {
            // Tải lại form + thông tin lỗi
            $this->load->view('Register');
        } else {
            // Lọc dữ liệu của form
            $username = htmlspecialchars($this->input->post('user_name', true));
            $pwd = htmlspecialchars($this->input->post('pwd', true));
            $confirm_pwd = htmlspecialchars($this->input->post('confirm_pwd', true));

            // Kiểm tra tên tài khoản đã tồn tại chưa
            if ($this->Account_Model->isExist($username)) {
                $info['error'] = 'Tên đăng nhập đã tồn tại';
            } else {
                // Nếu tên đăng nhập chưa tồn tại thì lưu tài khoản vào database
                $data = array('user_name' => $username, 'pwd' => md5($pwd), 'role_id' => 2);
                $this->Account_Model->create($data);
                $info['success'] = 'Đăng ký thành công';
                $this->load->view('Login', $info);
            }
        }
    }

    public function accountDetails($error = '') {
        // Nếu user không đăng nhập thì chuyển qua trang đăng nhập
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        } else {
            // Load dữ diệu tài khoản từ database
            $data['account'] = $this->Account_Model->get_by_id($this->session->userdata('account')->id);
            $data['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id);
            $data['error'] = $error;
            // Và load trang thông tin tài khoản
            $this->load->view('AccountDetails', $data);
        }
    }

    public function do_update() {
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }
        $this->form_validation->set_rules('full_name', 'Full name', 'trim|required');
        $this->form_validation->set_rules('pwd', 'Password', 'trim|required|min_length[3]|max_length[36]');
        $this->form_validation->set_rules('confirm_pwd', 'Password Confirmation', 'required|matches[pwd]');
        
        if ($this->input->post('update')) {
            // Nếu kiểm tra form thất bại thì tải lại trang xem sách
            if ($this->form_validation->run() == FALSE) {
                redirect(base_url().'Book_Controller/books');
            } else {
                
                // Nạp thông tin tài khoản vào $data
                $data['id'] = $this->input->post('account_id',true);
                $data['account'] = array(
                    'pwd' => md5($this->input->post('pwd',true)),
                    'full_name' => $this->input->post('full_name',true)
                );

                // Kiểm tra ảnh có được chọn hay không
                if (!$_FILES['image']['size'] == 0) {
                    // Nếu có thì tiến hành upload vào folder chứa ảnh của user
                    $upload_result = $this->Upload_Model->do_upload_image('image', 'USER');
                    // Nếu update thành công
                    if ($upload_result != null) {
                        // Tạo đường dẫn mới cho user
                        $data['account']['image'] = '/images/user/' . $upload_result['upload_data']['file_name'];
                    }
                }

                // Tiến hành update thông tin
                $this->Account_Model->update($data['id'], $data['account']);
                redirect(base_url() . 'Account_Controller/accountDetails');
            }
        }
    }
    
    public function forgot($data=null){
        if($data!=null){
            $param['error']=$data['error'];
        }
        else{
            $param['error']='';
        }
        $this->load->view('ForgotPwd',$param);
    }
    
    // Đổi mật khẩu/ quên mật khẩu
    public function recovery() {
        
        //validate form input
        $this->form_validation->set_rules('user_name', 'user_name', 'trim|required|min_length[3]|max_length[36]|alpha_dash');
        $this->form_validation->set_rules('pwd', 'Pasword', 'trim|required|min_length[3]|max_length[36]');
        $this->form_validation->set_rules('confirm_pwd', 'Password Confirmation', 'trim|required|matches[pwd]');
        if ($this->input->post('recovery')) {
            if ($this->form_validation->run() == FALSE) {
                // Nếu validate thất bại thì trả lại lỗi
                $this->forgot(array('error' => validation_errors()));
            } else {
                // Kiểm tra tên đăng nhập có tồn tại hay không
                if (!$this->Account_Model->isExist($this->input->post('user_name',true))) {
                    $this->forgot(array('error' => 'Username không tồn tại'));
                } else {
                    // Nếu tồn thì thì tiến hành cập nhật mật khẩu mới
                    $this->Account_Model->update_password(md5($this->input->post('pwd',true)),$this->input->post('user_name',true));
                    $data['success'] = 'Đổi mật khẩu thành công';
                    $this->load->view('Login', $data);
                }
            }
        }
    }

}
