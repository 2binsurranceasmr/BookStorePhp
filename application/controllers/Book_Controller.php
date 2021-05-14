<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Book_Controller extends CI_Controller {

    public function index() {

        $this->load->view('index');
    }

    public function books() {


        // Định nghĩa các thông tin khi tạo pagination và param chứa thông tin truyền vào view

        $params = array();

        // Xác định quyền của account đang đăng nhập, mặc định là user
        if ($this->session->userdata('account') != null) {
            $params['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id);
        } else {
            $params['role'] = 'USER';
        }

        $limit_per_page = 5; // Mỗi trang hiển thị 5 sách
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; // Lấy segment 3 nếu tồn tại làm offset truy vấn
        $total_records = $this->Book_Model->get_total(); // Tổng số sách có trong database
        // Nếu có hơn 1 sách thì nạp dữ liệu sách vào params
        if ($total_records > 0) {

            // Lấy dữ liệu của page hiện tại nạp vào param
            $params["results"] = $this->Book_Model->get_current_page_records($limit_per_page, $start_index);

            // Config cho pagination
            $config['base_url'] = base_url() . 'Book_Controller/books'; // Đường dẫn
            $config['total_rows'] = $total_records; // Số lượng sách
            $config['per_page'] = $limit_per_page;  // Số lượng sách hiển thị mỗi trang
            $config["uri_segment"] = 3; // Vị trí segment
            // Custom pagination, gồm các thẻ, thanh url và định dạng hiển thị cho pagination

            $config['num_links'] = 1; // Tối đa 1 link hiển thị trước hoặc sau


            $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = 'Trang đầu';
            $config['first_tag_open'] = '<li class="page-item" >';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = 'Trang cuối';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link" >';
            $config['cur_tag_close'] = '</span></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $config['attributes'] = array('class' => "page-link"); // Thêm attribute vào thẻ <a> được tạo
            // Tạo paging links
            $this->pagination->initialize($config);

            // Nạp paging links vào param
            $params["links"] = $this->pagination->create_links();
        }

        $this->load->view('Books', $params);
    }

    // Ghé thăm cửa hàng mà không cần đăng nhập
    public function visit() {
        // Xóa session nếu bấm nút ghé thăm
        $this->books();
    }
    
    // Kiểm tra có phải admin mở trang này không
    public function booksAdmin() {
        // Nếu không có tài khoản nào đăng nhập
        if ($this->session->userdata('account') == null) {
            // gửi lỗi
            show_404();
        } else {
            // Tiếp tục kiểm tra role
            if ($this->session->userdata('account')->role_id != 1) {
                // Nếu không phải admin thì hiển thị lỗi
                show_404();
            } else {
                // Nếu đúng thì chuyển sang trang books
                $this->books();
            }
        }
    }

    // Hiển thị thông tin chi tiết của sách
    public function bookDetails($id) {
        // Phải đăng nhập mới có thể xem chi tiết
        if ($this->session->userdata('account') == null) {
            redirect(base_url() . 'Account_Controller/login');
        }

        $param = array();

        // Lấy thông tin sách nhét vào param
        $book = $this->Book_Model->get_by_id($id);
        $book_author = $this->Author_Model->get_by_id($book->author_id);

        // Tên tác giả
        $book_author_name = $book_author->full_name;

        // Nạp data vào param
        $param['book'] = $book;
        $param['author'] = $book_author_name;
        $param['role'] = $this->Role_Model->getName($this->session->userdata('account')->role_id);

        // Tải view với param đã có thông tin
        $this->load->view('BookDetails', $param);
    }
    
    // Load form thêm sách
    public function addBook() {
        // Lấy danh sách tác giả
        $data['authors'] = $this->Author_Model->get_all();
        // Lấy danh sách thể loại
        $data['categories'] = $this->Category_Model->get_all();
        $data['role'] = 'ADMIN';
        $this->load->view('AddBook', $data);
    }
    
    // Load form chỉnh sửa sách
    public function updateBook($id) {
        
        // Kiểm tra $id có tồn tại hay không
        if ($this->Book_Model->does_have($id)) {
            
            // Nếu có thì lấy sách từ database
            $book = $this->Book_Model->get_by_id($id);
            
            // Tạo dữ liệu hiển thị cho sách
            $data['book'] = array(
                'title' => $book->title,
                'author' => $this->Author_Model->get_by_id($book->author_id)->full_name,
                'price' => $book->price,
                'image' => $book->image,
                'category' => $this->Category_Model->get_by_id($book->category_id)->name,
                'publish_year' => $book->publish_year,
                'description' => $book->description,
                'id' => $book->id,
            );
            
            // Lấy danh sách tác giả
            $data['authors'] = $this->Author_Model->get_all();
            // Lấy danh sách thể loại
            $data['categories'] = $this->Category_Model->get_all();
            $data['role'] = 'ADMIN';
            $this->load->view('UpdateBook', $data);
        } else {
            show_404();
        }
    }

    public function do_add() {
        // kiểm tra form
        $this->form_validation->set_rules('author_id', 'Author', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|min_length[4]');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('publish_year', 'Publish Year', 'required|is_natural');
        
        
        if ($this->form_validation->run() == FALSE) {
            // Tải lại trang xem sách
            redirect(base_url().'Book_Controller/books');
        } else {
            
            // Lấy thông tin từ form
            $data['book'] = array(
                'author_id' => $this->input->post('author_id'),
                'category_id' => $this->input->post('category_id'),
                'price' => $this->input->post('price'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'publish_year' => $this->input->post('publish_year')
            );

            // Kiểm tra có ảnh nào được chọn không
            if (!$_FILES['image']['size'] == 0) {
                // Nếu có thì tiến hành upload vào folder chứa ảnh của sách
                $upload_result = $this->Upload_Model->do_upload_image('image', 'BOOK');
                // Nếu update thành công
                if ($upload_result != null) {
                    // Tạo đường dẫn mới cho sách
                    $data['book']['image'] = '/images/book/' . $upload_result['upload_data']['file_name'];
                }
            }
            // Thêm sách vào database
            $this->Book_Model->insert($data['book']);
            redirect(base_url() . 'Book_Controller/books');
        }
    }

    public function do_update() {

        // kiểm tra form
        $this->form_validation->set_rules('author_id', 'Author', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|min_length[4]');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('publish_year', 'Publish Year', 'required|is_natural');
        if ($this->form_validation->run() == FALSE) {
            // Tải lại trang xem sách
            redirect(base_url().'Book_Controller/books');
        } else {
            $data['book'] = array(
                'author_id' => $this->input->post('author_id'),
                'category_id' => $this->input->post('category_id'),
                'price' => $this->input->post('price'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'publish_year' => $this->input->post('publish_year')
            );

            $data['book_id'] = $this->input->post('book_id');

            // Kiểm tra có ảnh nào được chọn không
            if (!$_FILES['image']['size'] == 0) {
                // Nếu có thì tiến hành upload vào folder chứa ảnh của sách
                $upload_result = $this->Upload_Model->do_upload_image('image', 'BOOK');
                // Nếu update thành công
                if ($upload_result != null) {
                    // Tạo đường dẫn mới cho sách
                    $data['book']['image'] = '/images/book/' . $upload_result['upload_data']['file_name'];
                }
            }
            $this->Book_Model->update($data['book_id'], $data['book']);
            redirect('Book_Controller/booksAdmin');
        }
    }
    
    // Tìm sách
    public function search() {
        
        if ($this->input->post('search')) {
            // Nếu input không null thì tiến hành tìm kiếm
            if ($this->input->post('book_title')) {
                $books = $this->Book_Model->search_by_title(htmlspecialchars($this->input->post('book_title',true)));
                // Và load trang xem kết quả tìm kiếm
                $this->book_search($books);
            } else {
                redirect(base_url() . 'Book_Controller/books');
            }
        }
    }

    public function book_search($books) {
        
        // Kiểm tra user đang đăng nhập hay không
        if ($this->session->userdata('account') != null) {
            // Nếu có thì set role
            $role = $this->Role_Model->getName($this->session->userdata('account')->role_id);
        } else {
            // Nếu không thì dùng role mặc định là USER
            $role = 'USER';
        }
        if ($books != null) {
            // Nếu book có tìm thấy thì load trang books với dữ liệu tìm thấy
            $this->load->view('Books', array('results' => $books, 'role' => $role));
        } else {
            redirect(base_url() . 'Book_Controller/books');
        }
    }

}
